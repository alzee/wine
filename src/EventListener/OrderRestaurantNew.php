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
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, entity: OrderRestaurant::class)]
class OrderRestaurantNew extends AbstractController
{
    public function postPersist(OrderRestaurant $order, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        // restaurant + withdrawable
        $resta = $order->getRestaurant();
        $voucher = $order->getVoucher();
        $discount = $resta->getDiscount();
        $actualAmount = $voucher * $discount;
        $resta->setWithdrawable($resta->getWithdrawable() + $actualAmount);

        // customer - voucher
        $customer = $order->getCustomer();
        $customer->setVoucher($customer->getVoucher() - $voucher);

        // voucher record for customer
        $record = new Voucher();
        $consumers = $em->getRepository(Org::class)->findOneByType(4);
        $record->setOrg($consumers);
        $record->setCustomer($customer);
        $record->setVoucher(-$voucher);
        $type = Choice::VOUCHER_TYPES['餐饮消费'];
        $record->setType($type);
        $em->persist($record);

        $em->flush();
    }
}
