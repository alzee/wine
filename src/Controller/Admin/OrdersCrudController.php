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
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Org;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrdersCrudController extends AbstractCrudController
{
    private $doctrine;

    private $statuses = ['Pending' => 0, 'Cancelled' => 4, 'Success' => 5];

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
        $orgRepo = $this->doctrine->getRepository(Org::class);
        $user = $this->getUser();
        $userOrg = $orgRepo->findOneBy(['id' => $user->getOrg()]);
        $roles = $user->getRoles();
        if ($this->isGranted('ROLE_HEAD')) {
            $seller = $orgRepo->findOneByType(0);
        }
        if ($this->isGranted('ROLE_AGENCY')) {
            $seller = $orgRepo->findOneByType(0);
        }
        if ($this->isGranted('ROLE_STORE')) {
            $seller = $orgRepo->find($userOrg->getUpstream());
        }
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('seller')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $seller)
            ),
            AssociationField::new('buyer')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $user->getOrg())
            ),
            AssociationField::new('product')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.org = :org')->setParameter('org', $seller)
            ),
            CollectionField::new('orderItems'),
            IntegerField::new('quantity'),
            MoneyField::new('amount')->setCurrency('CNY'),
            MoneyField::new('voucher')->setCurrency('CNY'),
            ChoiceField::new('status')->setChoices($this->statuses),
            TextareaField::new('note'),
        ];
    }

    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        $b = $this->createEditFormBuilder($entityDto, $formOptions, $context);
        $f = $b->getForm();
        if ($f->get('status')->getData() > 3) {
            $b->add('status', ChoiceType::class, ['choices' => $this->statuses, 'disabled' => 'disabled']);
            $f = $b->getForm();
        }
        return $f;
    }
}
