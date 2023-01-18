<?php

namespace App\Controller\Admin;

use App\Entity\Reg;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class RegCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reg::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', 'RegList')
            ->setSearchFields(['name', 'phone', 'submitter.name'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('type')
            ->setChoices(Choice::REG_TYPES)
        ;
        yield TextField::new('orgName');
        yield TextField::new('name', 'Contact');
        yield TextField::new('phone');
        yield TextField::new('address');
        yield AssociationField::new('submitter');
    }
}
