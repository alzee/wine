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
use App\Entity\Voucher;

class OrdersUpdate
{
    public function postUpdate(Orders $order, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($order);
        $status = $order->getStatus();

        if (isset($changeSet['status'])) {
            if ($status == 5) {
                $seller_product = $order->getProduct();
                $sn = $seller_product->getSn();
                $seller = $order->getSeller();
                $buyer = $order->getBuyer();
                $quantity = $order->getQuantity();
                $voucher = $order->getVoucher();
                // seller stock - quantity
                $seller_product->setStock($seller_product->getStock() - $quantity);
                // seller voucher + voucher
                $seller->setVoucher($seller->getVoucher() - $voucher);
                
                // if not find this product in buyer org, create it
                $buyer_product = $em->getRepository(Product::class)->findOneByOrgAndSN($buyer, $sn);
                if (is_null($buyer_product)) {
                    $buyer_product = clone $seller_product;
                    $buyer_product->setStock(0);
                    $buyer_product->setOrg($buyer);
                    $em->persist($buyer_product);
                }
                // buyer stock + quantity
                $buyer_product->setStock($buyer_product->getStock() + $quantity);
                // buyer voucher + voucher
                $buyer->setVoucher($buyer->getVoucher() + $voucher);


                // voucher record for seller
                $record = new Voucher();
                $record ->setOrg($seller);
                $record->setVoucher(-$voucher);
                $type = match ($seller->getType()) {
                    0 => 10,
                    1 => 11,
                    2 => 17,
                };
                $record->setType($type);
                $em->persist($record);

                // voucher record for buyer 
                $record = new Voucher();
                $record ->setOrg($buyer);
                $record->setVoucher($voucher);
                $record->setType($type - 10);
                $em->persist($record);

                $em->flush();
                dump($seller_product);
                dump($buyer_product);
            }
        }

    }
}
