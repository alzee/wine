<?php

namespace App\Controller\Admin;

use App\Entity\Conf;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class ConfCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conf::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('订单');
        yield IntegerField::new('returnDays');
        yield FormField::addTab('短信');
        yield ArrayField::new('cc');
        yield FormField::addTab('奖项');
        yield MoneyField::new('waiterTip')
                ->setCurrency('CNY')
            ;
        yield MoneyField::new('storeTip')
                ->setCurrency('CNY')
            ;
    }

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
