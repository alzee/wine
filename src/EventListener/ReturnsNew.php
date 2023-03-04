<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Returns;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Product;
use App\Entity\Voucher;
use App\Entity\Choice;
use App\Entity\Stock;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Returns::class)]
// #[AsEntityListener(event: Events::postPersist, entity: Returns::class)]
class ReturnsNew extends AbstractController
{
    public function prePersist(Returns $return, LifecycleEventArgs $event): void
    {
        $amount = 0;
        $voucher = 0;

        foreach ($return->getReturnItems() as $i) {
            $product = $i->getProduct();
            $quantity = $i->getQuantity();
            $price = $product->getPrice();
            $unitVoucher = $product->getVoucher();
            // accumulate voucher
            $amount += $price * $quantity;
            // accumulate amount
            $voucher += $unitVoucher * $quantity;
        }

        $return->setAmount($amount);
        $return->setVoucher($voucher);
    }

    public function postPersist(Returns $return, LifecycleEventArgs $event): void
    {
    }
}
