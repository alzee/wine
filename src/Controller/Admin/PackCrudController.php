<?php

namespace App\Controller\Admin;

use App\Entity\Pack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pack::class;
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
