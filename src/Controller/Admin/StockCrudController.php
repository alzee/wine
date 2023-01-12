<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class StockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stock::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // AssociationField::new('org'),
            // AssociationField::new('product'),
            TextField::new('product.sn', 'Sn'),
            TextField::new('product.name', 'Name'),
            TextField::new('product.spec', 'Spec'),
            MoneyField::new('product.price', 'Price')->setCurrency('CNY'),
            IntegerField::new('stock'),
            MoneyField::new('product.voucher', 'Voucher')
                ->setCurrency('CNY')
                ->setHelp('<b>代金券</b>为本件商品随增的代金券金额')
            ,
            MoneyField::new('product.refReward', 'Ref Reward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('product.orgRefReward', 'Org Ref Reward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('product.partnerReward', 'Partner Reward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('product.offIndustryStoreReward', 'Off Industry Store Reward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('product.offIndustryAgencyReward', 'Off Industry Agency Reward')
                ->setCurrency('CNY')
            ,
            ImageField::new('product.img', 'Product Image')
                ->onlyOnIndex()
                ->setBasePath('img/product/thumbnail/')
            ,
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.org = $userOrg");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::NEW, Action::EDIT)
        ;
    }
}
