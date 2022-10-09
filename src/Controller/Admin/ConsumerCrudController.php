<?php

namespace App\Controller\Admin;

use App\Entity\Consumer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ConsumerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consumer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('openid')
                ->setFormTypeOptions(['disabled' => 'disabled'])
                ->setHelp('微信openid')
            ,
            TextField::new('name', 'Consumer.name'),
            TextField::new('phone'),
            MoneyField::new('voucher')->setCurrency('CNY'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE)
                ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT, Action::DETAIL, Action::INDEX)
            ;
        }
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     $helpIndex = '';
    //     $helpNew = '';
    //     return $crud
    //         // ->setDefaultSort(['id' => 'DESC'])
    //         ->setHelp('index', $helpIndex)
    //         ->setHelp('new', $helpNew)
    //     ;
    // }
}
