<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            // ChoiceField::new('product'),
            AssociationField::new('agency'),
            AssociationField::new('product'),
            IntegerField::new('quantity'),
            IntegerField::new('price')->onlyOnIndex(),
            IntegerField::new('amount')->onlyOnIndex(),
            IntegerField::new('voucher')->onlyOnIndex(),
            ChoiceField::new('status')->setChoices(['Pending' => 0,'Success' => 9]),
        ];
    }
}
