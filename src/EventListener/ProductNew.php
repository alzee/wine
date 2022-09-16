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
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ProductNew extends AbstractController
{
    public function prePersist(Product $product, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $head = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
        // only if its not a clone in an order
        if (is_null($product->getOrg())) {
            $product->setOrg($head);
        }
    }

    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
    }
}
