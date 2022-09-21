<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Returns;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Product;
use App\Entity\Voucher;
use App\Entity\Choice;

class ReturnsNew extends AbstractController
{
    public function prePersist(Returns $return, LifecycleEventArgs $event): void
    {
        $amount = 0;
        $voucher = 0;

        foreach ($return->getReturnItems() as $i) {
            $product = $i->getProduct();
            $quantity = $i->getQuantity();
            $price = $product->getPrice();
            $unitVoucher = $product->getVoucher();
            // accumulate voucher
            $amount += $price * $quantity;
            // accumulate amount
            $voucher += $unitVoucher * $quantity;
        }

        $return->setAmount($amount);
        $return->setVoucher($voucher);
        $return->setStatus(5);
    }

    public function postPersist(Returns  $return, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $sender = $return->getSender();
        $recipient = $return->getRecipient();
        foreach ($return->getReturnItems() as $i) {
            $product = $i->getProduct();
            $quantity = $i->getQuantity();
            $sn = $product->getSn();
            $price = $product->getPrice();
            $unitVoucher = $product->getVoucher();
            // recipient product stock + quantity
            $product->setStock($product->getStock() + $quantity);
            // sender product stock - quantity
            $sender_product = $em->getRepository(Product::class)->findOneByOrgAndSN($sender, $sn);
            $sender_product->setStock($sender_product->getStock() - $quantity);
        }

        $voucher = $return->getVoucher();
        // sender voucher - voucher
        $sender->setVoucher($sender->getVoucher() - $voucher);

        // recipient voucher + voucher
        $recipient->setVoucher($recipient->getVoucher() + $voucher);

        // voucher record for sender
        $record = new Voucher();
        $record->setOrg($sender);
        $record->setVoucher(-$voucher);
        $type = Choice::VOUCHER_TYPES['退货发出'];
        $record->setType($type);
        $em->persist($record);

        // voucher record for recipient 
        $record = new Voucher();
        $record->setOrg($recipient);
        $record->setVoucher($voucher);
        $record->setType($type - 100);
        $em->persist($record);

        $em->flush();
    }
}
