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

class WithdrawCrudController extends AbstractCrudController
{
    private $doctrine;
    
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
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
        if ($this->isGranted('ROLE_RESTAURANT')){
            yield MoneyField::new('actualAmount')
                ->setCurrency('CNY')
                ->setFormTypeOptions(['disabled' => 'disabled']);
        }
        yield MoneyField::new('amount', 'withdraw.amount')
            ->setCurrency('CNY')
            ->onlyWhenCreating()
            ->setHelp('可提现金额: ' . $voucher / 100)
        // ->setFormTypeOptions(['option_name' => 'option_value'])
        ;
        if (!is_null($instance)) {
            if ($instance->getStatus() > 3 || $instance->getApprover() != $user->getOrg()) {
                yield ChoiceField::new('status')
                    ->setChoices(Choice::WITHDRAW_STATUSES)
                    ->hideWhenCreating()
                    ->setFormTypeOptions(['disabled' => 'disabled']);
            } else {
                yield ChoiceField::new('status')
                    ->setChoices(Choice::WITHDRAW_STATUSES)
                    ->hideWhenCreating();
            }
        }
        yield ChoiceField::new('status')
            ->setChoices(Choice::WITHDRAW_STATUSES)
            ->onlyOnIndex();
        yield DateTimeField::new('date')->HideOnForm();
        yield TextareaField::new('note');
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
            ;
        } else if ($this->isGranted('ROLE_STORE')){
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT, Action::DETAIL, Action::INDEX)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE)
            ;
        }
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if ($this->isGranted('ROLE_HEAD')) {
            $response->andWhere("entity.approver = $userOrg");
        } else {
            $response
                ->andWhere("entity.applicant = $userOrg")
                ->orWhere("entity.approver = $userOrg");
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
            'help' => '可提现金额: ' . $voucher / 100,
        ]);
        $f = $b->getForm();
        return $f;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('date')
        ;
    }
}
