<?php

namespace App\Controller\Admin;

use App\Entity\Org;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;

class OrgCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Org::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('contact'),
            TelephoneField::new('phone'),
            TextField::new('address'),
            TextField::new('district'),
            ChoiceField::new('type')->setChoices(['总部' => 0, '代理商' => 1,'门店' => 2]),
        ];
    }
}
