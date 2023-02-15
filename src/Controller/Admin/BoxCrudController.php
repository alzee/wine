<?php

namespace App\Controller\Admin;

use App\Entity\Box;
use App\Entity\Batch;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class BoxCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    
    public static function getEntityFqcn(): string
    {
        return Box::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm()
        ;
        yield IntegerField::new('sn')
            // ->onlyWhenCreating()
        ;
        yield ArrayField::new('cipher')
            ->hideWhenCreating()
        ;
        yield ArrayField::new('prize')
            ->hideWhenCreating()
        ;
        yield CollectionField::new('boxPrizes')
            ->hideOnIndex()
            // ->allowAdd(false)
            // ->allowDelete(false)
            ->renderExpanded()
            ->setRequired(true)
            ->useEntryCrudForm()
        ;
        yield AssociationField::new('batch')
            ->onlyOnIndex()
        ;
        yield IntegerField::new('batch.bottleQty')
            ->onlyOnIndex()
        ;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $batchNew = Action::new('batchNew')
            ->createAsGlobalAction()
            ->linkToUrl(function (){
                return $this->adminUrlGenerator
                    ->setController(BatchCrudController::class)
                    ->setDashboard(DashboardController::class)
                    ->setAction('new')
                    // ->set('menuIndex', 1)
                    ->set('type', 0)
                    ->generateUrl();
            });
        $batchEdit = Action::new('batchEdit')
            ->createAsGlobalAction()
            ->linkToUrl(function (){
                return $this->adminUrlGenerator
                    ->setController(BatchCrudController::class)
                    ->setDashboard(DashboardController::class)
                    ->setAction('new')
                    // ->set('menuIndex', 1)
                    ->set('type', 1)
                    ->generateUrl();
            });
        return $actions
            ->add('index', $batchNew)
            ->add('index', $batchEdit)
            ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL)
        ;
    }
}
