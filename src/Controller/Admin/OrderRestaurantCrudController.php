<?php

namespace App\Controller\Admin;

use App\Entity\OrderRestaurant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class OrderRestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderRestaurant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('restaurant')->HideWhenCreating(),
            AssociationField::new('restaurant')->onlyWhenCreating()->setQueryBuilder (
                fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $this->getUser()->getOrg())
            ),
            // TextField::new('orderNo')
            //     ->setHelp('顾客在餐厅消费的订单号')
            // ,
            // MoneyField::new('amount')
            //     ->setCurrency('CNY')
            //     ->setHelp('顾客在餐厅消费的订单金额')
            // ,
            MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->setHelp('顾客结账时抵用的代金券金额')
            ,
            AssociationField::new('consumer'),
            DateTimeField::new('date')->HideOnForm(),
            TextareaField::new('note'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::EDIT)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        // $helpIndex = '';
        $helpNew = '请填写<b>餐厅订单号</b>及<b>金额</b>以便于后期对账。';
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            // ->setHelp('index', $helpIndex)
            // ->setHelp('new', $helpNew)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('date')
        ;
    }
}
