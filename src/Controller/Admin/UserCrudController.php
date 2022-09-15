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

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('org')->HideWhenUpdating()->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type != 4')
            ),
            AssociationField::new('org')->OnlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
            TextField::new('username')->HideWhenUpdating(),
            TextField::new('username')->OnlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
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
}
