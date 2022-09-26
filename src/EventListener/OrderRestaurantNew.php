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
use App\Entity\Voucher;
use App\Entity\Org;
use App\Entity\Choice;

class OrderRestaurantNew extends AbstractController
{
    public function postPersist(OrderRestaurant $order, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        // restaurant + voucher
        $resta = $order->getRestaurant();
        $voucher = $order->getVoucher();
        $resta->setWithdrawable($resta->getWithdrawable() + $voucher);

        // consumer - voucher
        $consumer = $order->getConsumer();
        $consumer->setVoucher($consumer->getVoucher() - $voucher);

        // voucher record for consumer
        $record = new Voucher();
        $consumers = $em->getRepository(Org::class)->findOneByType(4);
        $record->setOrg($consumers);
        $record->setConsumer($consumer);
        $record->setVoucher(-$voucher);
        $type = Choice::VOUCHER_TYPES['餐饮消费'];
        $record->setType($type);
        $em->persist($record);

        // voucher record for restaurant
        $record = new Voucher();
        $record->setOrg($resta);
        $record->setVoucher($voucher);
        $record->setType($type - 100);
        $em->persist($record);

        $em->flush();
    }
}
