<?php

namespace App\Controller\Admin;

use App\Entity\Share;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShareCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Share::class;
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
