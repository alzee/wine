<?php

namespace App\Controller\Admin;

use App\Entity\Batch;
use App\Entity\BatchPrize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class BatchCrudController extends AbstractCrudController
{
    private RequestStack $requestStack;
    private $type;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();
        $this->type = $request->query->get('type');
    }
    
    public static function getEntityFqcn(): string
    {
        return Batch::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // yield FormField::addPanel('批量信息');
        yield FormField::addTab('批量信息');
        if (! is_null($this->type) && $this->type == 1) {
            yield TextField::new('snStart')
                ->setRequired(true)
                ->setColumns(6)
                ;
            yield TextField::new('snEnd')
                ->setColumns(6)
                ;
            yield IntegerField::new('qty')
                ->setRequired(false)
            ;
        }
        
        yield IdField::new('id')
            ->hideOnForm()
        ;
        if (! is_null($this->type) && $this->type == 0) {
            yield IntegerField::new('qty')
                ->onlyWhenCreating()
                ;
        }
        yield TextField::new('snStart')
            ->hideWhenCreating()
        ;
        yield TextField::new('snEnd')
            ->hideWhenCreating()
        ;

        // yield FormField::addPanel('每箱信息');
        yield FormField::addTab('每箱信息');
        yield IntegerField::new('bottleQty');
        yield CollectionField::new('batchPrizes')
            ->hideOnIndex()
            // ->allowAdd(false)
            // ->allowDelete(false)
            ->renderExpanded()
            ->setRequired(true)
            ->useEntryCrudForm()
        ;
        yield ArrayField::new('batchPrizes')
            ->onlyOnIndex()
        ;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        // if (! is_null($this->type) && $this->type == 1) {
        //     return $crud
        //         ->setPageTitle('edit', 'Batch New')
        //     ;
        // } else {
        //     return $crud
        //         ->setPageTitle('edit', 'Batch Edit')
        //     ;
        // }
        return $crud
            ->setPageTitle('new', fn () => $this->type == 1 ? 'Batch Edit' : 'Batch New');
        
    }

    public function createEntity(string $entityFqcn)
    {
        $batch = new Batch();
        $item = new BatchPrize();
        $batch->addBatchPrize($item);
        $batch->setType($this->type);
        
        return $batch;
    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];
        if ('saveAndReturn' === $submitButtonName) {
            $url = $this->container->get(AdminUrlGenerator::class)
                                   ->setController(BoxCrudController::class)
                                   ->setAction(Action::INDEX)
                                   ->set('menuIndex', 1)
                                   // ->set('subMenuIndex', 1)
                                   ->generateUrl();

            return $this->redirect($url);
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }
}
