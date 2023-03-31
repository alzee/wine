<?php

namespace App\Controller\Admin;

use App\Entity\Settle;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DatetimeField;

class SettleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Settle::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield AssociationField::new('salesman');
        yield AssociationField::new('claim');
        yield AssociationField::new('product');
        yield ChoiceField::new('type')
            ->setChoices(Choice::SETTLE_TYPES)
        ;
        yield ChoiceField::new('status')
            ->setChoices(Choice::SETTLE_STATUSES)
        ;
        yield BooleanField::new('delivered')
            ->renderAsSwitch(false)
            // ->setDisabled(true)
        ;
        yield DatetimeField::new('createdAt');
    }
    
    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::DETAIL)
                ->remove('index', Action::EDIT)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL)
            ;
        }
    }
}
