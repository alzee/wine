<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\OrderRestaurant;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class OrderRestaurantNew extends AbstractController
{
    public function postPersist(OrderRestaurant $order, LifecycleEventArgs $event): void
    {
        // restaurant + voucher
        $resta = $order->getRestaurant();
        $voucher = $order->getVoucher();
        $resta->setVoucher($resta->getVoucher() + $voucher);

        // consumer - voucher
        $consumer = $order->getConsumer();
        $consumer->setVoucher($consumer->getVoucher() - $voucher);

        $em = $event->getEntityManager();
        $em->flush();
    }
}
