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
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use App\Form\OrgTypeFilterType;

class OrgCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Org::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_HEAD')) {
            $orgChoices = ['Agency' => 1];
        }
        if ($this->isGranted('ROLE_AGENCY')) {
            $orgChoices = ['Store' => 2, 'Restaurant' => 3];
        }
        yield IdField::new('id')->onlyOnIndex();
        yield ImageField::new('img', 'org.img')
            ->onlyOnIndex()
            ->setBasePath('img/org/')
            ->setUploadDir('public/img/org/');
        yield ChoiceField::new('type')
            ->onlyWhenCreating()
            ->setChoices($orgChoices);
        yield ChoiceField::new('type')
            ->setChoices(Choice::ORG_TYPES)
            ->hideWhenCreating()
            ->setDisabled()
        ;
        yield TextField::new('name');
        yield TextField::new('contact');
        yield TelephoneField::new('phone');
        yield TextField::new('address');
        yield TextField::new('payee')
            ->setDisabled()
        ;
        yield TextField::new('bank')
            ->setDisabled()
        ;
        yield TextField::new('bank_account')
            ->setDisabled()
        ;
        yield TextField::new('bank_addr')
            ->setDisabled()
        ;
        yield TextField::new('district');
        yield MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->hideOnForm()
                // ->setFormTypeOptions(['disabled' => 'disabled'])
            ;
        if ($this->isGranted('ROLE_AGENCY')) {
            yield PercentField::new('discount');
        }
    }

    // public function configureAssets(Assets $assets): Assets
    // {
    //     return $assets
    //         ->addJsFile(Asset::new('js/z.js')->onlyOnForms()->defer())
    //     ;
    // }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            return $actions
                ->disable(Action::DELETE)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL, Action::INDEX)
            ;
        }
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     $help = '当<b>类型</b>选择<b>门店</b>或<b>餐厅</b>时，需要选择对应的上级代理商。';
    //     return $crud->setHelp('new', $help);
    // }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if ($this->isGranted('ROLE_HEAD')) {
            $response->andWhere("entity.id > 10");
        } else {
            $response->andWhere("entity.upstream = $userOrg");
        }
        return $response;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('type')->setFormType(OrgTypeFilterType::class))
        ;
    }
}
