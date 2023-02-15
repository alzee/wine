<?php

namespace App\Controller\Admin;

use App\Entity\Prize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class PrizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prize::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $instance = $this->getContext()->getEntity()->getInstance();
        if ($pageName === 'edit' && $instance->isBig()) {
            yield FormField::addTab('基本信息');
        }
        
        yield TextField::new('name');
        yield IntegerField::new('value');
        yield IntegerField::new('value2');
        yield IntegerField::new('expire');
        yield NumberField::new('odds')
            ->setNumDecimals(8)
            // ->setRoundingMode(\NumberFormatter::GROUPING_SIZE)
            ;
        yield BooleanField::new('big');
        if ($pageName === 'edit' && $instance->isBig()) {
            yield FormField::addTab('指定')
                ->setHelp('Specific Bottles')
                ;
            yield ArrayField::new('bottles', 'Bottle Sn format ABCD1234.1')
                ;
        }
    }
}
