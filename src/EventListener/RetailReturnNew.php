<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\RetailReturn;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Voucher;
use App\Entity\Org;
use App\Entity\Choice;

class RetailReturnNew extends AbstractController
{
    public function postPersist(RetailReturn $retailReturn, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $product = $retailReturn->getProduct();
        $quantity = $retailReturn->getQuantity();
        $amount = $quantity * $product->getPrice();
        $voucher = $quantity * $product->getVoucher();

        $retailReturn->setAmount($amount);
        $retailReturn->setVoucher($voucher);

        // store stock + quantity
        $product->setStock($product->getStock() + $quantity);

        // consumer - voucher
        $consumer = $retailReturn->getConsumer();
        $consumer->setVoucher($consumer->getVoucher() - $voucher);

        // store + voucher
        $store = $retailReturn->getStore();
        $store->setVoucher($store->getVoucher() + $voucher);

        // voucher record for store
        $record = new Voucher();
        $record->setOrg($store);
        $record->setVoucher($voucher);
        $type = Choice::VOUCHER_TYPES['零售退货'];
        $record->setType($type);
        $em->persist($record);

        // voucher record for consumer
        $record = new Voucher();
        $consumers = $em->getRepository(Org::class)->findOneByType(4);
        $record->setOrg($consumers);
        $record->setConsumer($consumer);
        $record->setVoucher(-$voucher);
        $record->setType($type + 100);
        $em->persist($record);

        $em->flush();
    }
}
