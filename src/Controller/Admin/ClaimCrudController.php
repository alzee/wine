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
        yield IdField::new('id')
            ->onlyOnIndex()
        ;
        yield AssociationField::new('retail')
            ->onlyOnIndex()
        ;
        yield AssociationField::new('store')
            ->onlyOnIndex()
        ;
        yield AssociationField::new('customer')
            ->onlyOnIndex()
        ;
        yield AssociationField::new('bottle')
            ->onlyOnIndex()
        ;
        yield AssociationField::new('product')
            ->onlyOnIndex()
        ;
        yield AssociationField::new('prize')
            ->onlyOnIndex()
        ;
        yield ChoiceField::new('status')
            ->setChoices(Choice::CLAIM_STATUSES)
        ;
        yield AssociationField::new('serveStore')
            ->onlyOnIndex()
        ;
        yield BooleanField::new('storeSettled')->renderAsSwitch(false);
        yield BooleanField::new('serveStoreSettled')->renderAsSwitch(false);
        yield DatetimeField::new('createdAt')
            ->onlyOnIndex()
        ;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->disable(Action::DELETE, Action::NEW, Action::DETAIL);
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $actions
                ->disable(Action::EDIT);
        }
        return $actions;
    }
}
