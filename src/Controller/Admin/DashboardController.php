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
use Doctrine\Persistence\ManagerRegistry;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    private $chartBuilder;

    private $doctrine;

    public function __construct(ChartBuilderInterface $chartBuilder, ManagerRegistry $doctrine)
    {
      $this->chartBuilder = $chartBuilder;
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
        
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        $data = [
          'countAgencies' => $countAgencies,
          'countStroes' => $countStroes,
          'countRestaurants' => $countRestaurants,
          'countConsumers' => $countConsumers,
          'chart' => $chart
        ];
        return $this->render('dashboard.html.twig', $data);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('酒水营销平台');
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
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            $items = [
                MenuItem::linkToCrud('UserManage', 'fas fa-user', User::class),
            ];
            if ($this->isGranted('ROLE_HEAD')) {
                array_push($items, (MenuItem::linkToCrud('NodeManage', 'fas fa-file', Node::class)));
            }
            yield MenuItem::subMenu('Settings', 'fa fa-gear')->setSubItems($items);
        }
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setTimezone('Asia/Shanghai')
            ->setDateTimeFormat('yyyy/MM/dd HH:mm');
        ;
    }
}
