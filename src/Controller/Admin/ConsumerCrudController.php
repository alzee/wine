<?php

namespace App\Controller\Admin;

use App\Entity\Consumer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConsumerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consumer::class;
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
