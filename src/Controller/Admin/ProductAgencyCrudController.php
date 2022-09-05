<?php

namespace App\Controller\Admin;

use App\Entity\ProductAgency;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductAgencyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductAgency::class;
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
