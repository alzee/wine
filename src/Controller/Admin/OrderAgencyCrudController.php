<?php

namespace App\Controller\Admin;

use App\Entity\OrderAgency;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderAgencyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderAgency::class;
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
