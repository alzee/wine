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
use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postUpdate, entity: Returns::class)]
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
                foreach ($return->getReturnItems() as $item) {
                    $product = $item->getProduct();
                    $quantity = $item->getQuantity();
                    $sn = $product->getSn();
                    $price = $product->getPrice();
                    $unitVoucher = $product->getVoucher();

                    // sender stock - quantity,
                    $stockRecordOfSender= $em->getRepository(Stock::class)->findOneBy(['org' => $sender, 'product' => $product]);
                    $stockRecordOfSender->setStock($stockRecordOfSender->getStock() - $quantity);

                    // recipient stock + quantity, only if recipient is not head
                    if ($recipient->getType() != 0) {
                        $stockRecordOfRecipient = $em->getRepository(Stock::class)->findOneBy(['org' => $recipient, 'product' => $product]);
                        $stockRecordOfRecipient->setStock($stockRecordOfRecipient->getStock() + $quantity);
                    }
                    
                    $boxes = $item->getBoxes()->toArray();
                    foreach ($boxes as $box) {
                        $box->setOrg($recipient);
                    }
                }

                $em->flush();
            }
        }

    }
}
