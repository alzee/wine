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
use App\Entity\Choice;
use App\Entity\Stock;

class OrdersUpdate extends AbstractController
{
    public function postUpdate(Orders $order, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($order);
        $status = $order->getStatus();

        if (isset($changeSet['status'])) {
            if ($status == 5) {
                $seller = $order->getSeller();
                $buyer = $order->getBuyer();
                foreach ($order->getOrderItems() as $i) {
                    $product = $i->getProduct();
                    $sn = $product->getSn();
                    $quantity = $i->getQuantity();
                    $price = $product->getPrice();
                    $unitVoucher = $product->getVoucher();
                    // seller stock - quantity, only if seller is not head
                    if ($seller->getType() != 0) {
                        $stockRecordOfSeller = $em->getRepository(Stock::class)->findOneBy(['org' => $seller, 'product' => $product]);
                        $stockRecordOfSeller->setStock($stockRecordOfSeller->getStock() - $quantity);
                    }

                    // buyer stock + quantity
                    $stockRecordOfBuyer = $em->getRepository(Stock::class)->findOneBy(['org' => $buyer, 'product' => $product]);
                    // if not find this product in buyer org, create it
                    if (is_null($stockRecordOfBuyer)) {
                        $stockRecordOfBuyer = new Stock;
                        $stockRecordOfBuyer->setStock(0);
                        $stockRecordOfBuyer->setOrg($buyer);
                        $stockRecordOfBuyer->setProduct($product);
                        $em->persist($stockRecordOfBuyer);
                    }
                    // buyer stock + quantity
                    $stockRecordOfBuyer->setStock($stockRecordOfBuyer->getStock() + $quantity);
                }

                $voucher = $order->getVoucher();
                // seller voucher - voucher
                $seller->setVoucher($seller->getVoucher() - $voucher);

                // buyer voucher + voucher
                $buyer->setVoucher($buyer->getVoucher() + $voucher);

                // voucher record for seller
                $record = new Voucher();
                $record->setOrg($seller);
                $record->setVoucher(-$voucher);
                $type = Choice::VOUCHER_TYPES['发货'];
                $record->setType($type);
                $em->persist($record);

                // voucher record for buyer 
                $record = new Voucher();
                $record->setOrg($buyer);
                $record->setVoucher($voucher);
                $record->setType($type - 100);
                $em->persist($record);

                $em->flush();
            }
        }
    }
}
