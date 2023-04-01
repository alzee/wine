<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Prize;
use App\Entity\OrderRestaurant;
use App\Entity\Voucher;
use App\Entity\Stock;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Node;
use App\Entity\Box;
use App\Entity\Batch;
use App\Entity\Bottle;
use App\Entity\Org;
use App\Entity\Orders;
use App\Entity\Returns;
use App\Entity\Reg;
use App\Entity\Withdraw;
use App\Entity\Transaction;
use App\Entity\Retail;
use App\Entity\City;
use App\Entity\Industry;
use App\Entity\Conf;
use App\Entity\Share;
use App\Entity\Reward;
use App\Entity\Claim;
use App\Entity\Settle;
use App\Entity\Pack;
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
        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_VARIANT_STORE')) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(StockCrudController::class)->generateUrl());
        }
        if ($this->isGranted('ROLE_RESTAURANT')) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(OrderRestaurantCrudController::class)->generateUrl());
        }

        $orgRepo = $this->doctrine->getRepository(Org::class);
        $countAgencies = $orgRepo->count(['type' => 1]);
        $countStroes = $orgRepo->count(['type' => 2]);
        $countRestaurants = $orgRepo->count(['type' => 3]);
        $countCustomers = $this->doctrine->getRepository(User::class)->countCustomers();

        $data = [
          'countAgencies' => $countAgencies,
          'countStroes' => $countStroes,
          'countRestaurants' => $countRestaurants,
          'countCustomers' => $countCustomers,
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
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY')) {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-chart-simple');
            yield MenuItem::linkToCrud('OrgManage', 'fas fa-building', Org::class);
        }

        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('ProductManage', 'fas fa-wine-bottle', Product::class);
        }
        
        yield MenuItem::linkToCrud('MyStock', 'fas fa-warehouse', Stock::class);
        
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::linkToCrud('Orders', 'fas fa-cog', Orders::class)
                ->setController(OrdersCrudController::class);
                ;
            yield MenuItem::linkToCrud('Returns', 'fas fa-cog', Returns::class)
                ->setController(ReturnsCrudController::class);
                ;
        }

        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY')) {
            yield MenuItem::linkToCrud('Sale', 'fas fa-file-export', Orders::class)
                ->setController(SaleCrudController::class);
        }
        if (! $this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('Buy', 'fas fa-file-import', Orders::class)
                ->setController(BuyCrudController::class);
        }

        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY')) {
            yield MenuItem::linkToCrud('ReturnToMe', 'fas fa-receipt', Returns::class)
                ->setController(ReturnToMeCrudController::class);
        }
        if (! $this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('MyReturn', 'fas fa-file-invoice', Returns::class)
                ->setController(MyReturnCrudController::class);
        }

        if ($this->isGranted('ROLE_SUPER_ADMIN') || $this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_VARIANT_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            yield MenuItem::linkToCrud('Retail', 'fas fa-bag-shopping', Retail::class);
        }

        if ($this->isGranted('ROLE_RESTAURANT') || $this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::linkToCrud('OrderRestaurant', 'fas fa-utensils', OrderRestaurant::class);
        }

        if ($this->isGranted('ROLE_RESTAURANT') ||
            $this->isGranted('ROLE_AGENCY') ||
            $this->isGranted('ROLE_VARIANT_HEAD') ||
            $this->isGranted('ROLE_VARIANT_AGENCY') ||
            $this->isGranted('ROLE_VARIANT_STORE')) {
            yield MenuItem::linkToCrud('MyWithdraw', 'fas fa-money-bill', Withdraw::class)
                ->setController(MyWithdrawCrudController::class);
                ;
        }
        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY')) {
            yield MenuItem::linkToCrud('DownstreamWithdraw', 'fas fa-cash-register', Withdraw::class)
                ->setController(DownstreamWithdrawCrudController::class);
            ;
            yield MenuItem::linkToCrud('Transaction', 'fas fa-list', Transaction::class);
        }

        if (! $this->isGranted('ROLE_VARIANT_HEAD') && ! $this->isGranted('ROLE_VARIANT_AGENCY') && ! $this->isGranted('ROLE_VARIANT_STORE')) {
            yield MenuItem::linkToCrud('Voucher.detail', 'fas fa-ticket', Voucher::class);
        }

        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('Reward.detail', 'fas fa-money-bill', Reward::class);
        }

        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY') || $this->isGranted('ROLE_VARIANT_STORE')) {
            yield MenuItem::linkToCrud('Share.detail', 'fas fa-money-bill-transfer', Share::class);
        }

        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('Claim', 'fas fa-award', Claim::class);
            yield MenuItem::linkToCrud('Settle', 'fas fa-gift', Settle::class);
            yield MenuItem::linkToCrud('RegList', 'fas fa-handshake-alt', Reg::class);
        }
        yield MenuItem::linkToCrud('Chpwd', 'fas fa-key', User::class)
            ->setController(PasswordCrudController::class)
            ->setAction('edit')
            ->setEntityId($this->getUser()->getId());
        yield MenuItem::linkToCrud('MyOrg', 'fas fa-shop', Org::class)
            ->setController(MyOrgCrudController::class)
            ->setAction('edit')
            ->setEntityId($this->getUser()->getOrg()->getId());

        if ($this->isGranted('ROLE_HEAD')) {
            yield MenuItem::linkToCrud('Featured', 'fas fa-wine-glass', Node::class)
                ->setController(FeaturedCrudController::class);
            ;
        }

        if ($this->isGranted('ROLE_HEAD') || $this->isGranted('ROLE_AGENCY') || $this->isGranted('ROLE_VARIANT_HEAD') || $this->isGranted('ROLE_VARIANT_AGENCY')) {
            $items = [
                MenuItem::linkToCrud('UserManage', 'fas fa-user', User::class),
            ];
            if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                array_push($items, (MenuItem::linkToCrud('Batch', 'fas fa-qrcode', Batch::class)));
            }
            if ($this->isGranted('ROLE_HEAD')) {
                array_push($items, (MenuItem::linkToCrud('BoxManage', 'fas fa-box', Box::class)));
                array_push($items, (MenuItem::linkToCrud('BottleManage', 'fas fa-bottle-water', Bottle::class)));
                array_push($items, (MenuItem::linkToCrud('PackManage', 'fas fa-cube', Pack::class)));
                array_push($items, (MenuItem::linkToCrud('PrizeManage', 'fas fa-medal', Prize::class)));
                array_push($items, (MenuItem::linkToCrud('NodeManage', 'fas fa-file', Node::class)));
                array_push($items, (MenuItem::linkToCrud('CityManage', 'fas fa-city', City::class)));
                array_push($items, (MenuItem::linkToCrud('IndustryManage', 'fas fa-industry', Industry::class)));
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
            ->setDefaultSort(['id' => 'DESC'])
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
            // ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ;
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            // ->addJsFile(Asset::new('js/initChart.js')->defer())
            ->addCssFile('css/main.css')
        ;
    }
}
