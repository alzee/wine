<?php

namespace App\Controller\Admin;

use App\Entity\Conf;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ConfCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conf::class;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     yield MoneyField::new('refReward', 'Org Ref Reward')
    //         ->setCurrency('CNY')
    //     ;
    // }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::INDEX)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::INDEX, Action::EDIT)
            ;
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('detail', 'Conf')
        ;
    }
}
