<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Orders;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Product;
use App\Entity\Stock;
use App\Entity\Voucher;
use App\Entity\Choice;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Orders::class)]
#[AsEntityListener(event: Events::postPersist, entity: Orders::class)]
class OrdersNew extends AbstractController
{
    public function prePersist(Orders $order, LifecycleEventArgs $event): void
    {
        $amount = 0;
        $voucher = 0;

        foreach ($order->getOrderItems() as $i) {
            $product = $i->getProduct();
            $quantity = $i->getQuantity();
            $price = $product->getPrice();
            $unitVoucher = $product->getVoucher();
            // accumulate voucher
            $amount += $price * $quantity;
            // accumulate amount
            $voucher += $unitVoucher * $quantity;
        }

        $order->setAmount($amount);
        $order->setVoucher($voucher);
        $order->setStatus(5);
    }

    public function postPersist(Orders $order, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

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
