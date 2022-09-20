<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->onlyOnIndex(),
            TextField::new('sn')
                ->HideWhenUpdating()
                ->setHelp('<b>商品编号</b>为总公司内部常用商品编号')
            ,
            TextField::new('sn')->onlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
            TextField::new('name'),
            TextField::new('spec'),
            MoneyField::new('price')->setCurrency('CNY'),
            IntegerField::new('stock')
                ->HideWhenUpdating()
                ->setHelp('<b>请正确填写库存</b>，为保证流转正常，创建后不能修改库存<br/>')
            ,
            IntegerField::new('stock')->onlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
            MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->setHelp('<b>代金券</b>为本件商品随增的代金券金额')
            ,
            // AssociationField::new('org')
            //     ->HideWhenUpdating()
            //     ->setQueryBuilder(
            //         fn (QueryBuilder $qb) => $qb->andWhere('entity.type < 3')
            //     ),
            // AssociationField::new('org')
            //     ->onlyWhenUpdating()
            //     ->setFormTypeOptions(['disabled' => 'disabled'])
            // ,
        ];
    }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //     ;
    // }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.org = $userOrg");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                // ->remove(Crud::PAGE_INDEX, Action::DELETE)
                ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT)
                ->add('index', Action::DETAIL)
            ;
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        $help = '<b>商品编号</b>为总公司内部常用商品编号<br/><b>请正确填写库存</b>，为保证流转正常，创建后不能修改库存<br/><b>代金券</b>为本件商品随增的代金券金额';
        return $crud
            // ->showEntityActionsInlined()
            ->setHelp('new', $help)
        ;
    }
}
