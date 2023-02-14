<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\OrderItems;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use App\Service\Sn;

#[AsEntityListener(event: Events::prePersist, entity: OrderItems::class)]
class OrderItemsNew extends AbstractController
{
    public function prePersist(OrderItems $item, LifecycleEventArgs $event): void
    {
        dump($item);
        $snStart = $item->getSnStart();
        dump($snStart);
        $boxid = Sn::toId($snStart);
        dump($boxid);
        $item->setStart($boxid);
        dump($item->getStart());
        dump($item);
    }
}
