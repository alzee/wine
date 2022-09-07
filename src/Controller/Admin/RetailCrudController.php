<?php

namespace App\Controller\Admin;

use App\Entity\Retail;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RetailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Retail::class;
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
