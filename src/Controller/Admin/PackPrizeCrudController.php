<?php

namespace App\Controller\Admin;

use App\Entity\PackPrize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Doctrine\ORM\QueryBuilder;

class PackPrizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PackPrize::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('prize')
            // ->onlyWhenCreating()
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.big = 0')
            )
        ;
        yield IntegerField::new('qty')
            // ->onlyWhenCreating()
        ;
    }
}
