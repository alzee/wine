<?php

namespace App\Controller\Admin;

use App\Entity\Claim;
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

class ClaimCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Claim::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield AssociationField::new('retail');
        yield AssociationField::new('store');
        yield AssociationField::new('customer');
        yield AssociationField::new('bottle');
        yield AssociationField::new('product');
        yield AssociationField::new('prize');
        yield ChoiceField::new('status')
            ->setChoices(Choice::CLAIM_STATUSES)
            ;
        yield AssociationField::new('serveStore');
        yield BooleanField::new('storeSettled')->renderAsSwitch(false);
        yield BooleanField::new('serveStoreSettled')->renderAsSwitch(false);
        yield DatetimeField::new('createdAt');
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL)
        ;
    }
}
