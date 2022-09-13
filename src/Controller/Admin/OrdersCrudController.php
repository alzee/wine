<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
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
use Doctrine\ORM\QueryBuilder;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();
        dump($user->getOrg());
        $roles = $user->getRoles();
        if ($this->isGranted('ROLE_HEAD')) {
            $userOrgType = 0;
            $upStreamOrgType = 0;
            $downStreamOrgType = 1;
            $seller = $user->getOrg();
        }
        if ($this->isGranted('ROLE_AGENCY')) {
            $userOrgType = 1;
            $upStreamOrgType = 0;
            $downStreamOrgType = 1;
            $seller = 5;
        }
        if ($this->isGranted('ROLE_STORE')) {
            $userOrgType = 2;
            $upStreamOrgType = 1;
            $downStreamOrgType = 2;
            $seller = 3;
        }
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('seller')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type = :type')->setParameter('type', $upStreamOrgType)
            ),
            AssociationField::new('buyer')->setQueryBuilder(
                // fn (QueryBuilder $qb) => $qb->andWhere('entity.type = :type')->setParameter('type', $downStreamOrgType)
                fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $user->getOrg())
            ),
            AssociationField::new('product')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.org = :org')->setParameter('org', $seller)
            ),
            IntegerField::new('quantity'),
            MoneyField::new('amount')->setCurrency('CNY'),
            MoneyField::new('voucher')->setCurrency('CNY'),
            ChoiceField::new('status')->setChoices(['Pending' => 0, 'Cancelled' => 4, 'Success' => 5]),
            TextareaField::new('note'),
        ];
    }
}
