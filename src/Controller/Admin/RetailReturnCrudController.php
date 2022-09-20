<?php

namespace App\Controller\Admin;

use App\Entity\RetailReturn;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RetailReturnCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RetailReturn::class;
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
