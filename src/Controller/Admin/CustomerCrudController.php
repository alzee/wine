<?php

namespace App\Controller\Admin;

use App\Entity\User;
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
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->onlyOnIndex(),
            TextField::new('openid')
                ->setDisabled()
                ->setHelp('微信openid')
            ,
            TextField::new('name', 'Customer.name'),
            TextField::new('nick')
                ->setDisabled()
            ,
            TextField::new('phone')
                ->setDisabled()
            ,
            MoneyField::new('voucher')
                ->setDisabled()
                ->setCurrency('CNY'),
            MoneyField::new('reward')
                ->setDisabled()
                ->setCurrency('CNY'),
            MoneyField::new('withdrawable')
                ->setDisabled()
                ->setCurrency('CNY'),
            MoneyField::new('withdrawing')
                ->setDisabled()
                ->setCurrency('CNY'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
                ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT, Action::DETAIL, Action::INDEX)
            ;
        }
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
            ->andWhere("entity.roles like '%ROLE_CUSTOMER%'");
        return $response;
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('openid'))
            ->add(TextFilter::new('name'))
            ->add(TextFilter::new('nick'))
            ->add(TextFilter::new('phone'))
            ->add(NumericFilter::new('voucher'))
            ->add(NumericFilter::new('reward'))
            ->add(NumericFilter::new('withdrawable'))
            ->add(NumericFilter::new('withdrawing'))
        ;
    }
}
