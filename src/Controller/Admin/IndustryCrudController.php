<?php

namespace App\Controller\Admin;

use App\Entity\Industry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class IndustryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Industry::class;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['weight' => 'ASC'])
        ;
    }
}
