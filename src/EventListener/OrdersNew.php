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

// #[AsEntityListener(event: Events::prePersist, entity: Orders::class)]
// #[AsEntityListener(event: Events::postPersist, entity: Orders::class)]
class OrdersNew extends AbstractController
{
    public function prePersist(Orders $order, LifecycleEventArgs $event): void
    {
    }

    public function postPersist(Orders $order, LifecycleEventArgs $event): void
    {
    }
}
