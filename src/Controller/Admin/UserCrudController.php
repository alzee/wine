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
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use App\Entity\Choice;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $userOrgId = $this->getUser()->getOrg()->getId();
        yield IdField::new('id')->onlyOnIndex();
        yield
            TextField::new('username')->OnlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']);
        yield TextField::new('username')->HideWhenUpdating();
        yield AssociationField::new('org')
            ->HideWhenUpdating()
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere("entity.id = $userOrgId")
                    ->orWhere("entity.upstream = $userOrgId")
            );
        yield TextField::new('name', 'Person Name')->HideWhenUpdating();
        yield TextField::new('nick')->HideWhenUpdating();
        yield AssociationField::new('org')
            ->OnlyWhenUpdating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield ChoiceField::new('roles')
            ->setChoices([
                'Salesman' => 'ROLE_SALESMAN',
                'Admin' => 'ROLE_ADMIN',
                'Head' => 'ROLE_HEAD',
                'Agency' => 'ROLE_AGENCY',
                'Store' => 'ROLE_STORE',
                'Restaurant' => 'ROLE_RESTAURANT',
                'VariantHead' => 'ROLE_VARIANT_HEAD',
                'VariantAgency' => 'ROLE_VARIANT_AGENCY',
                'VariantStore' => 'ROLE_VARIANT_STORE',
                'salesman' => 'ROLE_SALESMAN',
                'storeman' => 'ROLE_STOREMAN',
                'org_admin' => 'ROLE_ORG_ADMIN',
                'waiter' => 'ROLE_WAITER',
                'customer' => 'ROLE_CUSTOMER',
                'salesman_restaurant' => 'ROLE_SALESMAN_RESTAURANT',
            ])
            ->allowMultipleChoices()
            ->onlyOnIndex()
        ;
        yield ChoiceField::new('roles')
            ->setChoices([
                'salesman' => 'ROLE_SALESMAN',
                'storeman' => 'ROLE_STOREMAN',
                // 'org_admin' => 'ROLE_ORG_ADMIN',
                'waiter' => 'ROLE_WAITER',
                'salesman_restaurant' => 'ROLE_SALESMAN_RESTAURANT',
            ])
            ->allowMultipleChoices()
            ->onlyOnForms()
            ->setRequired(false)
        ;
        yield TextField::new('phone');
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
                ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT, Action::DETAIL, Action::INDEX)
            ;
        }
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrgId = $this->getUser()->getOrg()->getId();
        $uid = $this->getUser()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
            // ->leftJoin('entity.org', 'org')
            ->andWhere("entity.id != $uid")
            // ->andWhere("entity.id > 100")
            // ->andWhere("entity.org = $userOrgId OR org.upstream = $userOrgId")
        ;
        return $response;
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('username'))
            ->add(EntityFilter::new('org'))
            ->add(ArrayFilter::new('roles')->setChoices([
                '业务员' => 'ROLE_SALESMAN',
                '餐厅业务员' => 'ROLE_SALESMAN_RESTAURANT',
                '仓管' => 'ROLE_STOREMAN',
                '商家管理员' => 'ROLE_ORG_ADMIN',
                '服务员' => 'ROLE_WAITER',
            ]))
            ->add(TextFilter::new('phone'))
        ;
    }
}
