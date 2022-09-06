<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Orders;
use App\Entity\Product;
use App\Entity\Org;

class OrdersUpdate
{
    public function postUpdate(Orders $order, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($order);
        $status = $order->getStatus();

        if (isset($changeSet['status'])) {
        dump($status);
            if ($status == 5) {
                $product = $order->getProduct();
                $sn = $product->getSn();
                $seller = $order->getSeller();
                $buyer = $order->getBuyer();
                $quantity = $order->getQuantity();
                $voucher = $order->getVoucher();
                // seller stock - quantity
                // if not find this product in buyer org, create it
                $buyer_product = $em->getRepository(Product::class)->findOneByOrgAndSN($buyer, $sn);
                dump($buyer_product);
                // if ($buyer_product) {
                //     // $p = new Product();
                //     $p = clone $product;
                //     $p->setStock(0);
                //     $p->setOrg($buyer);
                // }
                // // buyer stock + quantity
                // // buyer voucher + voucher
                // $em->persist($buyer_product);
                // $em->flush();
            }
        }

    }
}
