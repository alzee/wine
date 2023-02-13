<?php

namespace App\Controller\Admin;

use App\Entity\BoxPrize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class BoxPrizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BoxPrize::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('box')
            ->onlyWhenCreating()
        ;
        yield AssociationField::new('prize')
            ->onlyWhenCreating()
            // ->setQueryBuilder(
            //     fn (QueryBuilder $qb) => $qb
            //         ->andWhere('entity.big = 0')
            // )
        ;
        yield IntegerField::new('qty')
            ->onlyWhenCreating()
        ;
    }
}
