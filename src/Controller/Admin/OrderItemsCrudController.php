<?php

namespace App\Controller\Admin;

use App\Entity\OrderItems;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;

class OrderItemsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderItems::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('product')
            ->onlyWhenCreating()
            //->setQueryBuilder(
            //    fn (QueryBuilder $qb) => $qb
            //        ->andWhere('entity.org = :org')
            //        ->setParameter('org', $this->getUser()->getOrg())
            //)
        ;
        yield AssociationField::new('product')
            ->HideWhenCreating()
            ->setFormTypeOptions(['disabled' => 'disabled'])
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.org = :org')
                    ->setParameter('org', $this->getUser()->getOrg())
            )
            ;
        yield IntegerField::new('quantity')
            ->onlyWhenCreating()
            ;
        yield IntegerField::new('quantity')
            ->setFormTypeOptions(['disabled' => 'disabled'])
            ->HideWhenCreating()
            ;
        yield TextField::new('snStart')
            ;
    }
}
