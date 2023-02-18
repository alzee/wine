<?php

namespace App\Controller\Admin;

use App\Entity\Claim;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClaimCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Claim::class;
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
