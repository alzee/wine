<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Returns;
use App\Entity\Product;
use App\Entity\Org;
use App\Entity\Voucher;

class ReturnsUpdate
{
    public function postUpdate(Returns $return, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($return);
        $status = $return->getStatus();

        if (isset($changeSet['status'])) {
            if ($status == 5) {
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

                $voucher = $return->getVoucher()
                // sender voucher - voucher
                $sender->setVoucher($sender->getVoucher() - $voucher);

                // recipient voucher + voucher
                $recipient->setVoucher($recipient->getVoucher() + $voucher);

                // voucher record for sender
                $record = new Voucher();
                $record->setOrg($sender);
                $record->setVoucher(-$voucher);
                $type = match ($sender->getType()) {
                    1 => 12,
                    2 => 13,
                };
                $record->setType($type);
                $em->persist($record);

                // voucher record for recipient 
                $record = new Voucher();
                $record->setOrg($recipient);
                $record->setVoucher($voucher);
                $record->setType($type - 10);
                $em->persist($record);

                $em->flush();
            }
        }

    }
}
