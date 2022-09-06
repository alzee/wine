<?php

namespace App\Controller\Admin;

use App\Entity\Returns;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;

class ReturnsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Returns::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('sender'),
            AssociationField::new('recipient'),
            AssociationField::new('product'),
            IntegerField::new('quantity'),
            IntegerField::new('amount'),
            IntegerField::new('voucher'),
            ChoiceField::new('status')->setChoices(['Pending' => 0, 'Success' => 5]),
        ];
    }
}
