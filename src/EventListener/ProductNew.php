<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Entity\Org;
use App\Entity\Stock;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Product::class)]
class ProductNew extends AbstractController
{
    public function prePersist(Product $product, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $head = $em->getRepository(Org::class)->findOneBy(['type' => 0]);

        $stockRecord = new Stock;
        $stockRecord->setStock(100);
        $stockRecord->setOrg($head);
        $stockRecord->setProduct($product);

        $em->persist($stockRecord);
    }
}
