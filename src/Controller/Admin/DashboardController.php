<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Product;
use App\Entity\ProductAgency;
use App\Entity\ProductStore;
use App\Entity\ProductRestaurant;
use App\Entity\Order;
use App\Entity\OrderAgency;
use App\Entity\OrderStore;
use App\Entity\OrderRestaurant;
use App\Entity\Voucher;
use App\Entity\Agency;
use App\Entity\Store;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Node;
use App\Entity\Org;
use App\Entity\Orders;
use App\Entity\Returns;
use App\Entity\Consumer;
use App\Entity\Withdraw;
use App\Entity\Retail;
use App\Entity\RetailReturn;
use App\Entity\City;
use App\Entity\Industry;
use App\Entity\Conf;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\UX\Chartjs\Model\Chart;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class DashboardController extends AbstractDashboardController
{

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
      $this->doctrine = $doctrine;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_STORE')) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
        }
        if ($this->isGranted('ROLE_RESTAURANT')) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(OrderRestaurantCrudController::class)->generateUrl());
        }

        $orgRepo = $this->doctrine->getRepository(Org::class);
        $countAgencies = $orgRepo->count(['type' => 1]);
        $countStroes = $orgRepo->count(['type' => 2]);
        $countRestaurants = $orgRepo->count(['type' => 3]);
        $countConsumers = $this->doctrine->getRepository(Consumer::class)->count([]);

        $data = [
          'countAgencies' => $countAgencies,
          'countStroes' => $countStroes,
          'countRestaurants' => $countRestaurants,
          'countConsumers' => $countConsumers,
        ];
        return $this->render('dashboard.html.twig', $data);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('剑南老窖营销平台');
    }

    public function configureMenuItems(): iterable
    {
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-chart-simple');
            yield MenuItem::linkToCrud('OrgManage', 'fas fa-building', Org::class);
        }

        yield MenuItem::linkToCrud('MyProduct', 'fas fa-wine-bottle', Product::class);

        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            yield MenuItem::linkToCrud('Sale', 'fas fa-file-export', Orders::class)
                ->setController(SaleCrudController::class);
        }
        if (!$this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('Buy', 'fas fa-file-import', Orders::class)
                ->setController(BuyCrudController::class);
        }

        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            yield MenuItem::linkToCrud('ReturnToMe', 'fas fa-receipt', Returns::class)
                ->setController(ReturnToMeCrudController::class);
        }
        if (!$this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('MyReturn', 'fas fa-file-invoice', Returns::class)
                ->setController(MyReturnCrudController::class);
        }

        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            yield MenuItem::linkToCrud('Retail', 'fas fa-bag-shopping', Retail::class);
            yield MenuItem::linkToCrud('RetailReturn', 'fas fa-cart-shopping', RetailReturn::class);
        }

        if ($this->isGranted('ROLE_RESTAURANT')) {
            yield MenuItem::linkToCrud('OrderRestaurant', 'fas fa-utensils', OrderRestaurant::class);
        }

        if ($this->isGranted('ROLE_RESTAURANT') || $this->isGranted('ROLE_AGENCY')) {
            yield MenuItem::linkToCrud('MyWithdraw', 'fas fa-money-bill', Withdraw::class)
                ->setController(MyWithdrawCrudController::class);
                ;
        }
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            yield MenuItem::linkToCrud('DownstreamWithdraw', 'fas fa-cash-register', Withdraw::class)
                ->setController(DownstreamWithdrawCrudController::class);
            ;
        }

        yield MenuItem::linkToCrud('Voucher.detail', 'fas fa-ticket', Voucher::class);

        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('ConsumerManage', 'fas fa-users', Consumer::class);
        }
        yield MenuItem::linkToCrud('Chpwd', 'fas fa-cog', User::class)
            ->setController(PasswordCrudController::class)
            ->setAction('edit')
            ->setEntityId($this->getUser()->getId());
        yield MenuItem::linkToCrud('MyOrg', 'fas fa-cog', Org::class)
            ->setController(MyOrgCrudController::class)
            ->setAction('edit')
            ->setEntityId($this->getUser()->getOrg()->getId());
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            $items = [
                MenuItem::linkToCrud('UserManage', 'fas fa-user', User::class),
            ];
            if ($this->isGranted('ROLE_HEAD')) {
                array_push($items, (MenuItem::linkToCrud('NodeManage', 'fas fa-file', Node::class)));
                array_push($items, (MenuItem::linkToCrud('CityManage', 'fas fa-file', City::class)));
                array_push($items, (MenuItem::linkToCrud('IndustryManage', 'fas fa-file', Industry::class)));
                array_push($items, (MenuItem::linkToCrud('Conf', 'fas fa-cog', Conf::class)->setAction('detail')->setEntityId(1)));
            }
            yield MenuItem::subMenu('Settings', 'fa fa-gear')->setSubItems($items);
        }
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->showEntityActionsInlined()
            ->setTimezone('Asia/Shanghai')
            ->setDateTimeFormat('yyyy/MM/dd HH:mm')
        ;
    }

    public function configureActions(): Actions
    {
        return Actions::new()
            // ->addBatchAction(Action::BATCH_DELETE)
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)

            ->add(Crud::PAGE_DETAIL, Action::EDIT)
            ->add(Crud::PAGE_DETAIL, Action::INDEX)
            ->add(Crud::PAGE_DETAIL, Action::DELETE)

            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ;
    }

    // public function configureAssets(): Assets
    // {
    //     return Assets::new()
    //         ->addJsFile(Asset::new('js/initChart.js')->defer())
    //     ;
    // }
}
