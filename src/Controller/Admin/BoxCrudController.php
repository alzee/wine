<?php

namespace App\Controller\Admin;

use App\Entity\Box;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BoxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Box::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('quantity')
            ->onlyWhenCreating()
        ;
        yield TextField::new('sn', 'box.sn')
            ->hideWhenCreating()
        ;
        yield TextField::new('cipher')
            ->hideWhenCreating()
        ;
        yield IntegerField::new('bottleQty');
    }
}
