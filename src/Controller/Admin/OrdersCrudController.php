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
use App\Entity\Org;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

class OrdersCrudController extends AbstractCrudController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $prod = $this->doctrine->getRepository(Product::class)->find(1);
        $org = $this->doctrine->getRepository(Org::class)->find($prod->getOrg());
        $user = $this->getUser();
        $userOrg = $this->doctrine->getRepository(Org::class)->find($user->getOrg());
        dump($prod);
        dump($org);
        dump($userOrg);
        $roles = $user->getRoles();
        if ($this->isGranted('ROLE_HEAD')) {
            $upStreamOrgType = 0;
            $downStreamOrgType = 1;
            $seller = $this->doctrine->getRepository(Org::class)->findOneByType(0);
        }
        if ($this->isGranted('ROLE_AGENCY')) {
            $upStreamOrgType = 0;
            $downStreamOrgType = 1;
            $seller = $this->doctrine->getRepository(Org::class)->findOneByType(0);
        }
        if ($this->isGranted('ROLE_STORE')) {
            $upStreamOrgType = 1;
            $downStreamOrgType = 2;
            $userOrg = $this->doctrine->getRepository(Org::class)->find($user->getOrg());
            // $seller = $this->doctrine->getRepository(Org::class)->find($userOrg->getUpstream());
            $seller = $this->doctrine->getRepository(Org::class)->find($userOrg);
        }
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('seller')->setQueryBuilder(
                // fn (QueryBuilder $qb) => $qb->andWhere('entity.type = :type')->setParameter('type', $upStreamOrgType)
                fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $seller)
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
