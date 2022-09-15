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
use App\Entity\Org;
use App\Entity\Orders;
use App\Entity\Returns;
use App\Entity\Consumer;
use App\Entity\Withdraw;
use App\Entity\Retail;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

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
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-chart-simple');
            yield MenuItem::linkToCrud('Org', 'fas fa-building', Org::class);
        }
        yield MenuItem::linkToCrud('Product', 'fas fa-wine-bottle', Product::class);
        //yield MenuItem::linkToCrud('ProductAgency', 'fas fa-list', ProductAgency::class);
        //yield MenuItem::linkToCrud('ProductStore', 'fas fa-list', ProductStore::class);
        //yield MenuItem::linkToCrud('ProductRestaurant', 'fas fa-list', ProductRestaurant::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-receipt', Orders::class);
        if ($this->isGranted('ROLE_STORE')) {
            yield MenuItem::linkToCrud('Retail', 'fas fa-bag-shopping', Retail::class);
        }
        //yield MenuItem::linkToCrud('OrderAgency', 'fas fa-list', OrderAgency::class);
        //yield MenuItem::linkToCrud('OrderStore', 'fas fa-list', OrderStore::class);
        //yield MenuItem::linkToCrud('Agency', 'fas fa-list', Agency::class);
        //yield MenuItem::linkToCrud('Store', 'fas fa-list', Store::class);
        // yield MenuItem::linkToCrud('Restaurant', 'fas fa-utensils', Restaurant::class);
        if ($this->isGranted('ROLE_RESTAURANT')) {
            yield MenuItem::linkToCrud('OrderRestaurant', 'fas fa-utensils', OrderRestaurant::class);
        }
        yield MenuItem::linkToCrud('Withdraw', 'fas fa-money-bill', Withdraw::class);
        yield MenuItem::linkToCrud('Returns', 'fas fa-cart-arrow-down', Returns::class);
        yield MenuItem::linkToCrud('Voucher.detail', 'fas fa-ticket', Voucher::class);
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_RESTAURANT')) {
            yield MenuItem::linkToCrud('Consumer', 'fas fa-users', Consumer::class);
        }
        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        }
    }
}
