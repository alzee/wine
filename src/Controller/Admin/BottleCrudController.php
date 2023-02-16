<?php

namespace App\Controller\Admin;

use App\Entity\Bottle;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class BottleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bottle::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('box');
        yield TextField::new('sn', 'bottle.sn');
        yield TextField::new('cipher')
            ->setMaxLength(25)
            ->hideWhenCreating()
            ;
        yield AssociationField::new('prize');
        yield ChoiceField::new('status')
            ->setChoices(Choice::BOTTLE_STATUSES);
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::EDIT, Action::DETAIL, Action::NEW)
        ;
    }
}
