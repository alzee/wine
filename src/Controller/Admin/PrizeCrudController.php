<?php

namespace App\Controller\Admin;

use App\Entity\Prize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class PrizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prize::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield IntegerField::new('value');
        yield IntegerField::new('value2');
        yield IntegerField::new('expire');
        yield NumberField::new('odds')
            ->setNumDecimals(6)
            // ->setRoundingMode(\NumberFormatter::GROUPING_SIZE)
            ;
        yield BooleanField::new('big');
    }
}
