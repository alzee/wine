<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Retail;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Voucher;
use App\Entity\Org;
use App\Entity\Choice;
use App\Entity\Stock;

class RetailNew extends AbstractController
{
    public function postPersist(Retail $retail, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $product = $retail->getProduct();
        $quantity = $retail->getQuantity();
        $amount = $quantity * $product->getPrice();
        $voucher = $quantity * $product->getVoucher();
        $store = $retail->getStore();
        $consumer = $retail->getConsumer();

        $retail->setAmount($amount);
        $retail->setVoucher($voucher);

        // store stock - quantity
        $stockRecord = $em->getRepository(Stock::class)->findOneBy(['org' => $store, 'product' => $product]);
        $stockRecord->setStock($stockRecord->getStock() - $quantity);

        // consumer + voucher
        $consumer->setVoucher($consumer->getVoucher() + $voucher);

        // store - voucher
        $store->setVoucher($store->getVoucher() - $voucher);

        // voucher record for store
        $record = new Voucher();
        $record->setOrg($store);
        $record->setVoucher(-$voucher);
        $type = Choice::VOUCHER_TYPES['酒零售'];
        $record->setType($type);
        $em->persist($record);

        // voucher record for consumer
        $record = new Voucher();
        $consumers = $em->getRepository(Org::class)->findOneByType(4);
        $record->setOrg($consumers);
        $record->setConsumer($consumer);
        $record->setVoucher($voucher);
        $record->setType($type - 100);
        $em->persist($record);

        // refReward
        $referrer = $consumer->getReferrer();
        if (! is_null($referrer)) {
            $reward = $product->getRefReward();
            $referrer->setReward($referrer->getReward() + $reward);
        }

        if ($store->getType() == 12) {
            // orgRefReward
            $reward = $product->getOrgRefReward();
            $up = $store->getUpstream();
            $referrer = $store->getReferrer();
            $upReferrer = $up->getReferrer();
            if ($referrer) {
                $referrer->setReward($referrer->getReward() + $reward);
            }
            if ($upReferrer) {
                $upReferrer->setReward($upReferrer->getReward() + $reward);
            }
            // up of up, namely VariantHead?

            // partnerReward
            $reward = $product->getPartnerReward();
            $partner = $store->getUpstream()->getPartner();
            if ($partner) {
                $partner->setReward($partner->getReward() + $reward);
            }

            // offIndustryStoreReward
            $reward = $product->getOffIndustryStoreReward();
            $store->setReward($store->getReward() + $reward);

            // offIndustryAgencyReward
            $reward = $product->getOffIndustryAgencyReward();
            $up = $store->getUpstream();
            // $up = $em->getRepository(Org::class)->find(27);
            $up->setReward($up->getReward() + $reward);
        }

        $em->flush();
    }
}
