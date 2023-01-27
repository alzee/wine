<?php

namespace App\Controller\Admin;

use App\Entity\Withdraw;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use Symfony\Component\Form\FormInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Org;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Doctrine\ORM\EntityRepository as ER;
use App\Admin\Field\VichImageField;
use App\Service\FieldSum;

class DownstreamWithdrawCrudController extends AbstractCrudController
{
    private FieldSum $fieldsum;

    public function __construct(FieldSum $fieldsum)
    {
        $this->fieldsum = $fieldsum;
    }

    public static function getEntityFqcn(): string
    {
        return Withdraw::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $instance = $this->getContext()->getEntity()->getInstance();
        $user = $this->getUser();
        $org = $this->getUser()->getOrg();
        $voucher = $org->getVoucher();
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('applicant')
            ->HideWhenCreating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield AssociationField::new('applicant')
            ->onlyWhenCreating()
            ->setQueryBuilder (
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.id = :id')
                    ->setParameter('id', $this->getUser()
                    ->getOrg())
            );
        yield AssociationField::new('consumer')
            ->HideWhenCreating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield AssociationField::new('approver')
            ->HideWhenCreating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield AssociationField::new('approver')
            ->onlyWhenCreating()
            ->setQueryBuilder (
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.id = :id')
                    ->setParameter('id', $this->getUser()
                    ->getOrg()
                    ->getUpstream())
            );
        yield MoneyField::new('amount', 'withdraw.amount')
            ->setCurrency('CNY')
            ->HideWhenCreating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        if ($this->isGranted('ROLE_RESTAURANT') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_HEAD')){
            yield MoneyField::new('actualAmount')
                ->setCurrency('CNY')
                ->hideWhenCreating()
                ->setFormTypeOptions(['disabled' => 'disabled']);
        }
        yield MoneyField::new('amount', 'withdraw.amount')
            ->setCurrency('CNY')
            ->onlyWhenCreating()
            ->setHelp('可提现金额: ' . $voucher / 100)
        // ->setFormTypeOptions(['option_name' => 'option_value'])
        ;
        if (!is_null($instance)) {
            if ($instance->getStatus() > 3 ||
                ($instance->getApprover() != $user->getOrg() && ! $this->isGranted('ROLE_HEAD'))) {
                yield ChoiceField::new('status')
                    ->setChoices(Choice::WITHDRAW_STATUSES)
                    ->hideWhenCreating()
                    ->setFormTypeOptions(['disabled' => 'disabled']);
            } else if ($this->isGranted('ROLE_HEAD')){
                yield ChoiceField::new('status')
                    ->setChoices(Choice::WITHDRAW_STATUSES)
                    ->hideWhenCreating();
            } else {
                yield ChoiceField::new('status')
                    ->setChoices(['Pending' => 0, 'Approved' => 3 , 'Rejected' => 4])
                    ->hideWhenCreating();
            }
        }
        yield ChoiceField::new('status')
            ->setChoices(Choice::WITHDRAW_STATUSES)
            ->onlyOnIndex();
        yield DateTimeField::new('date')->HideOnForm();
        yield TextareaField::new('note');
        yield VichImageField::new('imageFile', 'withdraw.img')
            ->hideOnIndex()
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::NEW)
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (! $this->isGranted('ROLE_HEAD')) {
            $response->andWhere("entity.approver = $userOrg");
        }
        return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $helpIndex = '只有<b>餐厅</b>和<b>代理商</b>可以发起申请。<br/><b>餐厅</b>提交申请由<b>代理商</b>审核。<br/><b>代理商</b>提交申请由<b>总公司</b>审核。';
        $helpNew = '<b>申请方</b>为当前登录机构。<br/>只有<b>餐厅</b>和<b>代理商</b>可以发起申请。<br/><b>餐厅</b>提交申请由<b>代理商</b>审核。<br/><b>代理商</b>提交申请由<b>总公司</b>审核。';
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setHelp('index', $helpIndex)
            ->setHelp('new', $helpNew)
            ->setPageTitle('index', 'DownstreamWithdraw')
            ->setSearchFields(['applicant.name'])
            ->overrideTemplates([ 'crud/index' => 'admin/pages/index.html.twig', ])
        ;
    }

    public function createNewForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        $user = $this->getUser();
        $org = $this->getUser()->getOrg();
        $voucher = $org->getVoucher();
        $b = $this->createNewFormBuilder($entityDto, $formOptions, $context);
        $b->add('amount', MoneyType::class, [
            'label' => 'withdraw.amount',
            'currency' => 'CNY',
            'divisor' => 100,
            'required' => true,
            'constraints' => [new LessThanOrEqual(['value' => $voucher, 'message' => 'Exceeded'])],
            'help' => '<i id="withdrawHelp">可提现金额: <span class="withdrawable text-danger">' . $voucher / 100 . '</span><span class="more d-none">, 折扣 <span class="discount text-danger">' . $org->getDiscount() * 100 . '</span>%。<span class="discountHint">提现 <span class="amount text-danger">' .  $voucher / 100 . '</span> 实际到帐 <span class="actual text-success">' . $voucher / 100 * $org->getDiscount() . '</span></span></span></i>',
        ]);
        $f = $b->getForm();
        return $f;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $user = $this->getUser();
        return $filters
            ->add(DateTimeFilter::new('date'))
            ->add(
                EntityFilter::new('applicant')
                    ->setFormTypeOption(
                        'value_type_options.query_builder',
                        static fn(ER $rep) => $rep
                            ->createQueryBuilder('o')
                            ->andWhere('o.upstream = :userOrg')
                            ->setParameter('userOrg', $user->getOrg())
                    )
            )
        ;
    }

    public function configureAssets(Assets $assets): Assets
    {
        if ($this->isGranted('ROLE_RESTAURANT')) {
            return $assets
                ->addJsFile(Asset::new('js/withdraw.js')->onlyWhenCreating()->defer())
            ;
        } else {
            return $assets;
        }
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        $sumFieldNames = ['amount', 'actualAmount'];
        return $this->fieldsum->calc($responseParameters, $sumFieldNames);
    }
}
