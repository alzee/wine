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
                $sender_product = $return->getProduct();
                $sn = $sender_product->getSn();
                $sender = $return->getSender();
                $recipient = $return->getRecipient();
                $quantity = $return->getQuantity();
                $voucher = $return->getVoucher();
                // sender stock - quantity
                $sender_product->setStock($sender_product->getStock() - $quantity);
                // sender voucher + voucher
                $sender->setVoucher($sender->getVoucher() - $voucher);

                $recipient_product = $em->getRepository(Product::class)->findOneByOrgAndSN($recipient, $sn);
                // recipient stock + quantity
                $recipient_product->setStock($recipient_product->getStock() + $quantity);
                // recipient voucher + voucher
                $recipient->setVoucher($recipient->getVoucher() + $voucher);
                $em->flush();
            }
        }

    }
}
