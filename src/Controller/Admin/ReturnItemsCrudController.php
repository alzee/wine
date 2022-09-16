<?php

namespace App\Controller\Admin;

use App\Entity\ReturnItems;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Doctrine\ORM\QueryBuilder;

class ReturnItemsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReturnItems::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product')
                ->setQueryBuilder(
                    fn (QueryBuilder $qb) => $qb
                        ->andWhere('entity.org = :org')
                        ->setParameter('org', $this->getUser()->getOrg())
                ),
            IntegerField::new('quantity'),
        ];
    }
}
