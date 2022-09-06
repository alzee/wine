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

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('酒品营销平台');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Product', 'fas fa-list', Product::class);
        //yield MenuItem::linkToCrud('ProductAgency', 'fas fa-list', ProductAgency::class);
        //yield MenuItem::linkToCrud('ProductStore', 'fas fa-list', ProductStore::class);
        //yield MenuItem::linkToCrud('ProductRestaurant', 'fas fa-list', ProductRestaurant::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-list', Order::class);
        //yield MenuItem::linkToCrud('OrderAgency', 'fas fa-list', OrderAgency::class);
        //yield MenuItem::linkToCrud('OrderStore', 'fas fa-list', OrderStore::class);
        //yield MenuItem::linkToCrud('OrderRestaurant', 'fas fa-list', OrderRestaurant::class);
        //yield MenuItem::linkToCrud('Agency', 'fas fa-list', Agency::class);
        //yield MenuItem::linkToCrud('Store', 'fas fa-list', Store::class);
        yield MenuItem::linkToCrud('Org', 'fas fa-list', Org::class);
        yield MenuItem::linkToCrud('Restaurant', 'fas fa-list', Restaurant::class);
        yield MenuItem::linkToCrud('Voucher', 'fas fa-list', Voucher::class);
        yield MenuItem::linkToCrud('Returns', 'fas fa-list', Returns::class);
        yield MenuItem::linkToCrud('Consumer', 'fas fa-list', Consumer::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
    }
}
