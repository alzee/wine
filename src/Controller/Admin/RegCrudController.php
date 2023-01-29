<?php

namespace App\Controller\Admin;

use App\Entity\Reg;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class RegCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reg::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::NEW, Action::DETAIL)
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
        yield TextField::new('orgName')
            ->setDisabled()
            ;
        yield TextField::new('name', 'Contact')
            ->setDisabled()
            ;
        yield TextField::new('phone')
            ->setDisabled()
            ;
        yield TextField::new('address');
        yield AssociationField::new('submitter')
            ->setDisabled()
            ;
        yield ChoiceField::new('status')
            ->setChoices(Choice::REG_STATUSES)
        ;
        yield TextareaField::new('note')
            ->setMaxLength(15);
            ;
        yield DateTimeField::new('createdAt')
            ->hideOnForm()
            ;
    }
}
