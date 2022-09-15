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
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

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
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('seller')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $user->getOrg())
            ),
            AssociationField::new('buyer')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.upstream = :userOrg')
                    ->andWhere('entity.type != 3')
                    ->setParameter('userOrg', $user->getOrg())
            ),
            CollectionField::new('orderItems')
                ->OnlyOnForms()
                ->useEntryCrudForm(OrderItemsCrudController::class),
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.seller = $userOrg")->orWhere("entity.buyer = $userOrg");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE)
            ;
        }
    }
}
