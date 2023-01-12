<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use App\Admin\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;
    private RequestStack $requestStack;

    public function __construct(AdminUrlGenerator $adminUrlGenerator, RequestStack $requestStack)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->onlyOnIndex(),
            TextField::new('sn')
                ->HideWhenUpdating()
                ->setHelp('<b>商品编号</b>为总公司内部常用商品编号')
            ,
            TextField::new('sn')->onlyWhenUpdating()->setFormTypeOptions(['disabled' => 'disabled']),
            TextField::new('name'),
            TextField::new('spec'),
            MoneyField::new('price')->setCurrency('CNY'),
            MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->setHelp('<b>代金券</b>为本件商品随增的代金券金额')
            ,
            MoneyField::new('refReward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('orgRefReward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('partnerReward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('offIndustryStoreReward')
                ->setCurrency('CNY')
            ,
            MoneyField::new('offIndustryAgencyReward')
                ->setCurrency('CNY')
            ,
            ImageField::new('img', 'Product Image')
                ->onlyOnIndex()
                ->setBasePath('img/product/thumbnail/')
                // ->setUploadDir('public/img/product/')
            ,
            VichImageField::new('imageFile', 'Product Image')
            ->hideOnIndex()
        ];
    }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //     ;
    // }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.org = $userOrg");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        $export = Action::new('export', 'export')
            ->createAsGlobalAction()
            ->linkToUrl(function () {
                $request = $this->requestStack->getCurrentRequest();
                return $this->adminUrlGenerator->setAll($request->query->all())
                    ->setAction('export')
                    ->generateUrl();
            });
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE)
                ->add('index', $export)
                // ->remove(Crud::PAGE_INDEX, Action::DELETE)
                ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT)
                ->add('index', Action::DETAIL)
            ;
        }
    }

    public function export(AdminContext $context, TranslatorInterface $translator)
    {
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->container->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $queryBuilder = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters);
        $entities = $queryBuilder->getQuery()->getArrayResult();
        $title = [];
        foreach ($entities[0] as $key => $v) {
            array_push($title, $translator->trans(ucwords($key)));
        }
        foreach ($entities as &$entity) {
            $entity['price'] /= 100;
            $entity['voucher'] /= 100;
        }
        array_unshift($entities, $title);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($entities, null);

        $writer = new Xlsx($spreadsheet);

        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="产品列表.xlsx"');
        $response->headers->set('Cache-Control','max-age=0');
        return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $help = '<b>商品编号</b>为总公司内部常用商品编号<br/><b>请正确填写库存</b>，为保证流转正常，创建后不能修改库存<br/><b>代金券</b>为本件商品随增的代金券金额';
        return $crud
            // ->showEntityActionsInlined()
            ->setHelp('new', $help)
        ;
    }
}
