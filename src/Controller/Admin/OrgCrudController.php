<?php

namespace App\Controller\Admin;

use App\Entity\Org;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrgCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Org::class;
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
