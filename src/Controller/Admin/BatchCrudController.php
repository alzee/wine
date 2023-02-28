<?php

namespace App\Controller\Admin;

use App\Entity\Batch;
use App\Entity\BatchPrize;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DatetimeField;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class BatchCrudController extends AbstractCrudController
{
    private RequestStack $requestStack;
    private $type;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();
        $this->type = (int) $request->query->get('type');
        if ($this->type === null) {
            $this->type = 0;
        }
    }
    
    public static function getEntityFqcn(): string
    {
        return Batch::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if ($this->type > 0) {
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
        if ($this->type === 0) {
            // yield AssociationField::new('product')
            //     ->setRequired(true)
            // ;
            yield IntegerField::new('qty')
                ->onlyWhenCreating()
                ;
            yield IntegerField::new('bottleQty')
                ->onlyWhenCreating()
                ;
        }
        yield TextField::new('snStart')
            ->hideWhenCreating()
        ;
        yield TextField::new('snEnd')
            ->hideWhenCreating()
        ;
        yield ChoiceField::new('type')
            ->setChoices(Choice::BATCH_TYPES)
            ->onlyOnIndex()
        ;
        yield DatetimeField::new('createdAt')
            ->onlyOnIndex()
        ;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', fn () => 
                match ($this->type) {
                    0 => 'Batch New',
                    1 => 'Batch Edit',
                    2 => 'Batch Qr',
                    3 => 'Export Str',
                }
            );
    }

    public function createEntity(string $entityFqcn)
    {
        $batch = new Batch();
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
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove('index', Action::NEW)
            ->disable(Action::DELETE, Action::EDIT, Action::DETAIL)
        ;
    }
}
