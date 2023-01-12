<?php

namespace App\Controller\Admin;

use App\Entity\Reg;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RegCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reg::class;
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
