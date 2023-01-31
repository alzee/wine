<?php

namespace App\Controller\Admin;

use App\Entity\Reg;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class RegCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Reg::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $newOrg = Action::new('newOrg')
            ->linkToUrl(function (Reg $entity){
                return $this->adminUrlGenerator
                    ->setController(OrgCrudController::class)
                    ->setDashboard(DashboardController::class)
                    ->setAction('new')
                    // ->set('menuIndex', 1)
                    ->set('fromReg', $entity->getId())
                    ->generateUrl();
            })
            ->displayIf(static function ($entity) {
                return $entity->getStatus() == 0;
            })
            ;
        return $actions
            ->add('index', $newOrg)
            ->disable(Action::DELETE, Action::NEW, Action::DETAIL)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', 'RegList')
            ->setSearchFields(['name', 'phone', 'submitter.name'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $disabled = false;
        if ($pageName === 'edit') {
            $instance = $this->getContext()->getEntity()->getInstance();
            if ($instance->getStatus() !== 0) {
                $disabled = true;
            }
        }

        yield ChoiceField::new('type')
            ->setChoices(Choice::REG_TYPES)
            ->setDisabled($disabled)
        ;
        yield TextField::new('orgName')
            ->setDisabled($disabled)
            ;
        yield TextField::new('name', 'Contact')
            ->setDisabled($disabled)
            ;
        yield TextField::new('phone')
            ->setDisabled($disabled)
            ;
        yield TextField::new('address')
            ->setDisabled($disabled)
            ;
        yield AssociationField::new('submitter')
            ->setDisabled($disabled)
            ;
        yield ChoiceField::new('status')
            ->setDisabled($disabled)
            ->setChoices(Choice::REG_STATUSES)
        ;
        yield TextareaField::new('note')
            ->setMaxLength(15);
            ;
        yield DateTimeField::new('createdAt')
            ->hideOnForm()
            ;
    }
}
