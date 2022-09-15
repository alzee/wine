<?php

namespace App\Controller\Admin;

use App\Entity\OrderItems;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderItemsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderItems::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
