<?php

namespace App\Controller\Admin;

use App\Entity\Returns;
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

class ReturnsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Returns::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $instance = $this->getContext()->getEntity()->getInstance();
        $user = $this->getUser();
        yield IdField::new('id')->onlyOnIndex();
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
        yield CollectionField::new('returnItems')
            ->onlyWhenCreating()
            ->setFormTypeOptions(['required' => 'required'])
            ->useEntryCrudForm();
        yield CollectionField::new('returnItems')
            ->OnlyWhenUpdating()
            ->allowAdd(false)
            ->allowDelete(false)
            ->useEntryCrudForm();
        yield MoneyField::new('amount')
            ->setCurrency('CNY')
            ->onlyOnIndex();
        yield MoneyField::new('voucher')
            ->setCurrency('CNY')
            ->onlyOnIndex();
        if (!is_null($instance)) {
            if ($instance->getStatus() > 3 || $instance->getRecipient() != $user->getOrg()) {
                yield ChoiceField::new('status')
                    ->setChoices(Choice::ORDER_STATUSES)
                    ->hideWhenCreating()
                    ->setFormTypeOptions(['disabled' => 'disabled']);
            } else {
                yield ChoiceField::new('status')
                    ->setChoices(Choice::ORDER_STATUSES)
                    ->hideWhenCreating();
            }
        }
        yield ChoiceField::new('status')
            ->setChoices(Choice::ORDER_STATUSES)
            ->onlyOnIndex();
        yield DateTimeField::new('date')->HideOnForm();
        yield TextareaField::new('note');
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE)
            ;
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        $helpIndex = '退货由<b>接收方</b>创建。<br/>退货创建后默认为<b>待处理</b>状态，请检查并审核。';
        $helpNew = '退货由<b>接收方</b>创建。<br/><b>接收方</b>为当前登录机构，<b>退货方</b>为本机构下级。<br/>退货创建后默认为<b>待处理</b>状态，请检查并审核。';
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setHelp('index', $helpIndex)
            ->setHelp('new', $helpNew)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('date')
        ;
    }
}
