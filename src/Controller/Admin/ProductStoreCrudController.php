<?php

namespace App\Controller\Admin;

use App\Entity\ProductStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductStoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductStore::class;
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
