<?php

namespace App\Controller\Admin;

use App\Entity\Returns;
use App\Entity\ReturnItems;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Doctrine\ORM\EntityRepository as ER;

class ReturnToMeCrudController extends AbstractCrudController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public static function getEntityFqcn(): string
    {
        return Returns::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $instance = $this->getContext()->getEntity()->getInstance();
        $user = $this->getUser();
        // yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('sender')
            ->hideWhenUpdating()
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.upstream = :userOrg')
                    ->setParameter('userOrg', $user->getOrg())
            );
        yield AssociationField::new('sender')
            ->onlyWhenUpdating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield AssociationField::new('recipient')
            ->hideWhenUpdating()
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.id = :id')
                    ->setParameter('id', $user->getOrg())
            );
        yield AssociationField::new('recipient')
            ->onlyWhenUpdating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield TextField::new('FirstProduct')
            ->onlyOnIndex()
            ;
        yield IntegerField::new('FirstProductQuantity')
            ->onlyOnIndex()
            ;
        yield CollectionField::new('returnItems')
            ->onlyWhenCreating()
            ->allowAdd(false)
            ->allowDelete(false)
            ->renderExpanded()
            ->setFormTypeOptions(['required' => 'required'])
            ->useEntryCrudForm();
        yield CollectionField::new('returnItems')
            ->OnlyWhenUpdating()
            ->allowAdd(false)
            ->allowDelete(false)
            ->renderExpanded()
            ->useEntryCrudForm();
        yield MoneyField::new('amount')
            ->setCurrency('CNY')
            ->onlyOnIndex();
        yield MoneyField::new('voucher')
            ->setCurrency('CNY')
            ->onlyOnIndex();
        // if (!is_null($instance)) {
        //     if ($instance->getStatus() > 3 || $instance->getRecipient() != $user->getOrg()) {
        //         yield ChoiceField::new('status')
        //             ->setChoices(Choice::ORDER_STATUSES)
        //             ->hideWhenCreating()
        //             ->setFormTypeOptions(['disabled' => 'disabled']);
        //     } else {
        //         yield ChoiceField::new('status')
        //             ->setChoices(Choice::ORDER_STATUSES)
        //             ->hideWhenCreating();
        //     }
        // }
        // yield ChoiceField::new('status')
        //     ->setChoices(Choice::ORDER_STATUSES)
        //     ->onlyOnIndex();
        yield DateTimeField::new('date')->HideOnForm();
        yield TextareaField::new('note');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
            ->andWhere("entity.recipient = $userOrg");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::EDIT)
            ;
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        $more = '<br/>退货创建后默认为<b>待处理</b>状态，请检查并审核。';
        $helpIndex = '退货由<b>接收方</b>创建。';
        $helpNew = '退货由<b>接收方</b>创建。<br/><b>接收方</b>为当前登录机构，<b>退货方</b>为本机构下级。';
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setHelp('index', $helpIndex)
            ->setHelp('new', $helpNew)
            ->setPageTitle('index', 'ReturnToMe')
            ->setSearchFields(['sender.name', 'returnItems.product.name'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $user = $this->getUser();
        return $filters
            ->add(DateTimeFilter::new('date'))
            ->add(
                EntityFilter::new('sender')
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

    public function createEntity(string $entityFqcn)
    {
        $ret = new Returns();
        $item = new ReturnItems();
        $ret->addReturnItem($item);

        return $ret;
    }
}
