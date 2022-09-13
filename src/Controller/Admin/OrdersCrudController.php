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
        // $user = $this->getUser();
        // $roles = $user->getRoles();
        if ($this->isGranted('ROLE_HEAD')) {
            $userOrgType = 0;
            $upStreamOrgType = 0;
            $downStreamOrgType = 1;
        }
        if ($this->isGranted('ROLE_AGENCY')) {
            $userOrgType = 1;
            $upStreamOrgType = 0;
            $downStreamOrgType = 1;
        }
        if ($this->isGranted('ROLE_STORE')) {
            $userOrgType = 2;
            $upStreamOrgType = 1;
            $downStreamOrgType = 2;
        }
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('seller')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type = :type')->setParameter('type', $upStreamOrgType)
            ),
            AssociationField::new('buyer')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type = :type')->setParameter('type', $downStreamOrgType)
            ),
            AssociationField::new('product'),
            IntegerField::new('quantity'),
            MoneyField::new('amount')->setCurrency('CNY'),
            MoneyField::new('voucher')->setCurrency('CNY'),
            ChoiceField::new('type')->setChoices(['Head2Agency' => 1, 'Agency2Store' => 2]),
            ChoiceField::new('status')->setChoices(['Pending' => 0, 'Cancelled' => 4, 'Success' => 5]),
            TextareaField::new('note'),
        ];
    }
}
