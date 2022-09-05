<?php

namespace App\Controller\Admin;

use App\Entity\OrderStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderStoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderStore::class;
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
