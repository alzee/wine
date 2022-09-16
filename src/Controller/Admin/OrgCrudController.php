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
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class OrgCrudController extends AbstractCrudController
{
    private $isStore;
    private $context;
    private $entity;
    // Cannot autowire service "App\Controller\Admin\OrgCrudController": argument "$context" of method "__construct()" references class "EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext" but no such service exists.
    // public function __construct(AdminContext $context)
    // {
    // }

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
            ChoiceField::new('type')->setChoices(['Head' => 0, 'Agency' => 1, 'Store' => 2, 'Restaurant' => 3, 'Consumer' => 4])->hideWhenCreating()->setFormTypeOptions(['disabled' => 'disabled']),
            ChoiceField::new('type')->setChoices(['Agency' => 1, 'Store' => 2, 'Restaurant' => 3])->onlyWhenCreating(),
            AssociationField::new('upstream')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type <= 1')
            )->onlyOnForms()->addCssClass("upstream d-none"),
            MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->hideOnForm()
                // ->setFormTypeOptions(['disabled' => 'disabled'])
            ,
        ];
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addJsFile(Asset::new('js/z.js')->onlyOnForms()->defer())
        ;
    }

    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        $b = $this->createEditFormBuilder($entityDto, $formOptions, $context);
        $this->entity = $context->getEntity();
        $f = $b->getForm();
        if ($f->get('type')->getData() == 2) {
            $this->isStore = true;
            // $b->add('upstream');
            $f = $b->getForm();
        }
        return $f;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $help = '当<b>类型</b>选择<b>门店</b>或<b>餐厅</b>时，需要选择对应的上级代理商。';
        return $crud->setHelp('new', $help);
    }
}
