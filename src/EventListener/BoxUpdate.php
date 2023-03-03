<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Box;
use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postUpdate, entity: Box::class)]
class BoxUpdate extends AbstractController
{
    public function postUpdate(Box $box, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($box);

        if (isset($changeSet['bottleSold'])) {
            $bottleSold = $box->getBottleSold();
            $product = $box->getProduct();
            $bottleQty = $product->getBottleQty();
            $org = $box->getOrg();
            if ($bottleSold === $bottleQty) {
                $stockRecord = $em->getRepository(Stock::class)->findOneBy(['org' => $org, 'product' => $product]);
                $stockRecord->setStock($stockRecord->getStock() - 1);
            }
            $em->flush();
        }
    }
}
