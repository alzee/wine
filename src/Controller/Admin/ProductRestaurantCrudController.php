<?php

namespace App\Controller\Admin;

use App\Entity\ProductRestaurant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductRestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductRestaurant::class;
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
