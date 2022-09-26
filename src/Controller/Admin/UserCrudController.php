<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Entity\Org;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->onlyOnIndex(),
            TextField::new('username')->OnlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
            TextField::new('username')->HideWhenUpdating(),
            AssociationField::new('org')
                ->HideWhenUpdating()
                ->setQueryBuilder(
                    fn (QueryBuilder $qb) => $qb->andWhere('entity.type != 4')
                ),
            AssociationField::new('org')->OnlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
            TextField::new('plainPassword')->onlyOnForms()
                                           ->setFormType(RepeatedType::class)
                                           ->setFormTypeOptions([
                                               'type' => PasswordType::class,
                                               'first_options' => ['label' => 'Password'],
                                               'second_options' => ['label' => 'Repeat password'],
                                               'required' => 'required',
                                           ])
                                           ,

        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            return $actions;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT, Action::DETAIL, Action::INDEX)
            ;
        }
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrgId = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
            ->leftJoin('entity.org', 'org')
            ->andWhere("entity.org = $userOrgId")
            ->orWhere("org.upstream = $userOrgId");
        return $response;
    }
}
