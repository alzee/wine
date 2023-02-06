<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use App\Entity\OrderItems;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Org;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\EntityRepository as ER;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Contracts\Translation\TranslatorInterface;

class SaleCrudController extends AbstractCrudController
{
    private $doctrine;
    private AdminUrlGenerator $adminUrlGenerator;
    private RequestStack $requestStack;

    public function __construct(ManagerRegistry $doctrine, AdminUrlGenerator $adminUrlGenerator, RequestStack $requestStack)
    {
        $this->doctrine = $doctrine;
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $instance = $this->getContext()->getEntity()->getInstance();
        $user = $this->getUser();
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('seller')
            ->hideWhenUpdating()
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.id = :id')
                    ->setParameter('id', $user->getOrg())
            );
        yield AssociationField::new('seller')
            ->onlyWhenUpdating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield AssociationField::new('buyer')
            ->hideWhenUpdating()
            ->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb
                    ->andWhere('entity.upstream = :userOrg')
                    ->setParameter('userOrg', $user->getOrg())
            );
        yield AssociationField::new('buyer')
            ->onlyWhenUpdating()
            ->setFormTypeOptions(['disabled' => 'disabled']);
        yield TextField::new('FirstProduct')
            ->onlyOnIndex()
            ;
        yield IntegerField::new('FirstProductQuantity')
            ->onlyOnIndex()
            ;
        yield CollectionField::new('orderItems')
            ->onlyWhenCreating()
            ->allowAdd(false)
            ->allowDelete(false)
            ->renderExpanded()
            ->setRequired(true)
            ->useEntryCrudForm();
        yield CollectionField::new('orderItems')
            ->OnlyWhenUpdating()
            ->allowAdd(false)
            ->allowDelete(false)
            ->useEntryCrudForm();
        yield MoneyField::new('amount')
            ->setCurrency('CNY')
            ->onlyOnIndex();
        yield MoneyField::new('voucher')
            ->setCurrency('CNY')
            ->onlyOnIndex();
        // if (!is_null($instance)) {
        //     if ($instance->getStatus() > 3 || $instance->getSeller() != $user->getOrg()) {
        //         yield ChoiceField::new('status')
        //             ->setChoices(Choice::ORDER_STATUSES)
        //             ->hideWhenCreating()
        //             ->setFormTypeOptions(['disabled' => 'disabled']);
        //     } else {
        //         yield ChoiceField::new('status')
        //             ->setChoices(Choice::ORDER_STATUSES)
        //             ->hideWhenCreating();
        //     }
        // }
        // yield ChoiceField::new('status')
        //     ->setChoices(Choice::ORDER_STATUSES)
        //     ->onlyOnIndex();
        yield DateTimeField::new('date')->HideOnForm();
        yield TextareaField::new('note');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
            ->andWhere("entity.seller = $userOrg")
        ;
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
        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT)
                ->add('index', $export)
                // ->add('index', Action::DETAIL)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::EDIT)
                ->add('index', $export)
                // ->add('index', Action::DETAIL)
            ;
        }
    }

    public function export(AdminContext $context, TranslatorInterface $translator)
    {
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->container->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $queryBuilder = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters);
        $entities0 = $queryBuilder->getQuery()->execute();
        $entities = $queryBuilder->getQuery()->getArrayResult();
        $title = [];
        foreach ($entities[0] as $key => $v) {
            array_push($title, $key);
        }
        array_push($title, 'seller', 'buyer', 'product', 'quantity');
        foreach ($title as &$v) {
            $v = $translator->trans(ucwords($v));
        }
        foreach ($entities as $key => &$entity) {
            $entity['amount'] /= 100;
            $entity['voucher'] /= 100;
            $entity['status'] = $translator->trans(array_flip(Choice::ORDER_STATUSES)[$entity['status']]);
            $entity['date']->setTimezone(new \DateTimeZone('Asia/Shanghai'));
            $entity['seller'] = $entities0[$key]->getSeller()->getName();
            $entity['buyer'] = $entities0[$key]->getBuyer()->getName();
            $entity['product'] = $entities0[$key]->getOrderItems()[0]->getProduct()->getName();
            $entity['quantity'] = $entities0[$key]->getOrderItems()[0]->getQuantity();
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
        $response->headers->set('Content-Disposition', 'attachment;filename="销售订单.xlsx"');
        $response->headers->set('Cache-Control','max-age=0');
        return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $helpIndex = '订单由<b>发货方</b>创建。';
        $helpNew = '订单由<b>发货方</b>创建。<br/><b>发货方</b>为当前登录机构，<b>收货方</b>为本机构下级。';
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setHelp('index', $helpIndex)
            ->setHelp('new', $helpNew)
            ->setPageTitle('index', 'Sale')
            ->setSearchFields(['buyer.name', 'orderItems.product.name'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $user = $this->getUser();
        return $filters
            ->add(DateTimeFilter::new('date'))
            ->add(
                EntityFilter::new('buyer')
                    ->setFormTypeOption(
                        'value_type_options.query_builder',
                        static fn(ER $rep) => $rep
                            ->createQueryBuilder('o')
                            ->andWhere('o.upstream = :userOrg')
                            ->setParameter('userOrg', $user->getOrg())
                    )
                    // ->setFormTypeOption('value_type_options.multiple', true)
            )
        ;
    }

    public function createEntity(string $entityFqcn)
    {
        $ord = new Orders();
        $item = new OrderItems();
        $p = $this->doctrine->getRepository(Product::class)->findOneBy(['org' => $this->getUser()->getOrg()]);
        $item->setProduct($p);
        $ord->addOrderItem($item);

        return $ord;
    }
}
