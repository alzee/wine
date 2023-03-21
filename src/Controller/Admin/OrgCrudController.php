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
use App\Entity\Reg;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use App\Form\OrgTypeFilterType;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;

class OrgCrudController extends AbstractCrudController
{
    private $doctrine;
    private RequestStack $requestStack;

    public function __construct(ManagerRegistry $doctrine, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->doctrine = $doctrine;
    }

    public static function getEntityFqcn(): string
    {
        return Org::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_HEAD')) {
            $orgChoices = [
                'agency' => 1,
                'store' => 2,
                'restaurant' => 3,
                'variant_head' => 10,
                'variant_agency' => 11,
                'variant_store' => 12,
            ];
        }
        if ($this->isGranted('ROLE_AGENCY')) {
            $orgChoices = ['Store' => 2, 'Restaurant' => 3];
        }
        if ($this->isGranted('ROLE_VARIANT_HEAD')) {
            $orgChoices = ['VariantAgency' => 11];
        }
        if ($this->isGranted('ROLE_VARIANT_AGENCY')) {
            $orgChoices = ['VariantStore' => 12];
        }
        yield IdField::new('id')->onlyOnIndex();
        yield ImageField::new('img', 'org.img')
            ->onlyOnIndex()
            ->setBasePath('img/org/thumbnail/')
            // ->setUploadDir('public/img/org/')
        ;
        yield ChoiceField::new('type')
            ->onlyWhenCreating()
            ->setChoices($orgChoices);
        yield ChoiceField::new('type')
            ->setChoices(Choice::ORG_TYPES_ALL)
            ->hideWhenCreating()
            ->setDisabled()
        ;
        $request = $this->requestStack->getCurrentRequest();
        if (! is_null($request->query->get('fromReg'))) {
            yield AssociationField::new('upstream')
                ->setRequired(true)
                ->setQueryBuilder(
                    fn (QueryBuilder $qb) => $qb
                        ->andWhere('entity.type = 0')
                        ->orWhere('entity.type = 1')
                        ->orWhere('entity.type = 10')
                        ->orWhere('entity.type = 11')
                )
                ;
        }
        yield TextField::new('name');
        yield TextField::new('contact');
        yield TelephoneField::new('phone');
        yield TextField::new('area')
            ->setRequired(true)
            ;
        yield TextField::new('address');
        // yield AssociationField::new('city');
        yield AssociationField::new('industry');
        yield MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->hideOnForm()
                // ->setFormTypeOptions(['disabled' => 'disabled'])
            ;
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MoneyField::new('withdrawable')
                ->setCurrency('CNY')
                ->hideOnForm()
            ;
            yield MoneyField::new('withdrawing')
                ->setCurrency('CNY')
                ->hideOnForm()
            ;
            yield AssociationField::new('upstream')
                ->hideOnForm()
            ;
        }
        yield AssociationField::new('referrer')->hideOnIndex();
        yield AssociationField::new('admin')->hideOnIndex();
        yield AssociationField::new('salesman')->hideOnIndex();
        if ($this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_SUPER_ADMIN')) {
            yield PercentField::new('discount');
            yield BooleanField::new('display');
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
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY')) {
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
            ->add('industry')
        ;
    }

    public function createEntity(string $entityFqcn)
    {
        $org = new Org();

        $request = $this->requestStack->getCurrentRequest();
        $regId = $request->query->get('fromReg');
        if (is_null($regId)) {
            $org->setUpstream($this->getUser()->getOrg());
        } else {
            $reg = $this->doctrine->getRepository(Reg::class)->find($regId);
            $type = match ($reg->getType()) {
                0 => 2,
                1 => 1,
                2 => 10,
                3 => 11,
                4 => 12,
                default => 2
            };
            $org->setType($type);
            if (! is_null($reg->getOrgName())) {
                $org->setName($reg->getOrgName());
            }
            if (! is_null($reg->getName())) {
                $org->setContact($reg->getName());
            }
            if (! is_null($reg->getPhone())) {
                $org->setPhone($reg->getPhone());
            }
            if (! is_null($reg->getArea())) {
                $org->setArea($reg->getArea());
            }
            if (! is_null($reg->getAddress())) {
                $org->setAddress($reg->getAddress());
            }
            if (! is_null($reg->getSubmitter())) {
                $org->setReferrer($reg->getSubmitter());
            }
            $org->setReg($reg);
        }
        return $org;
    }
}
