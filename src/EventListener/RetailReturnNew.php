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
use App\Entity\Stock;
use App\Entity\Reward;
use App\Entity\Share;

class RetailReturnNew extends AbstractController
{
    public function postPersist(RetailReturn $retailReturn, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $product = $retailReturn->getProduct();
        $quantity = $retailReturn->getQuantity();
        $amount = $quantity * $product->getPrice();
        $voucher = $quantity * $product->getVoucher();
        $store = $retailReturn->getStore();
        $consumer = $retailReturn->getConsumer();

        $retailReturn->setAmount($amount);
        $retailReturn->setVoucher($voucher);

        // store stock + quantity
        $stockRecord = $em->getRepository(Stock::class)->findOneBy(['org' => $store, 'product' => $product]);
        $stockRecord->setStock($stockRecord->getStock() + $quantity);

        // consumer - voucher
        $consumer->setVoucher($consumer->getVoucher() - $voucher);

        // store + voucher
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

        // Reward referrer when consumer buy
        $referrer = $consumer->getReferrer();
        if (! is_null($referrer)) {
            $reward = $product->getRefReward() * $quantity;
            $referrer->setReward($referrer->getReward() - $reward);
            $rewardRecord = new Reward();
            $rewardRecord->setType(6);
            $rewardRecord->setStatus(3);
            $rewardRecord->setRetailReturn($retailReturn);
            $rewardRecord->setReferrer($referrer);
            $rewardRecord->setAmount(-$reward);
            $em->persist($rewardRecord);
        }

        // Reward referrer when store buy
        $reward = $product->getOrgRefReward() * $quantity;
        $referrer = $store->getReferrer();
        if ($referrer) {
            $referrer->setReward($referrer->getReward() - $reward);
            $rewardRecord = new Reward();
            $rewardRecord->setType(6);
            $rewardRecord->setStatus(3);
            $rewardRecord->setRetailReturn($retailReturn);
            $rewardRecord->setReferrer($referrer);
            $rewardRecord->setAmount(-$reward);
            $em->persist($rewardRecord);
        }

        if ($store->getType() == 12) {
            // variantStoreShare
            $share = $product->getVariantStoreShare() * $quantity;
            $store->setShare($store->getShare() - $share);

            $shareRecord = new Share();
            $shareRecord->setType(3);
            $shareRecord->setStatus(3);
            $shareRecord->setRetailReturn($retailReturn);
            $shareRecord->setOrg($store);
            $shareRecord->setAmount(-$share);
            $em->persist($shareRecord);

            // variantAgencyShare
            $share = $product->getVariantAgencyShare() * $quantity;
            $variantAgency = $store->getUpstream();
            $variantAgency->setShare($variantAgency->getShare() - $share);

            $shareRecord = new Share();
            $shareRecord->setType(3);
            $shareRecord->setStatus(3);
            $shareRecord->setRetailReturn($retailReturn);
            $shareRecord->setOrg($variantAgency);
            $shareRecord->setAmount(-$share);
            $em->persist($shareRecord);

            // variantHeadShare
            $share = $product->getVariantHeadShare() * $quantity;
            $variantHead = $variantAgency->getUpstream();
            $variantHead->setShare($variantHead->getShare() - $share);

            $shareRecord = new Share();
            $shareRecord->setType(3);
            $shareRecord->setStatus(3);
            $shareRecord->setRetailReturn($retailReturn);
            $shareRecord->setOrg($variantHead);
            $shareRecord->setAmount(-$share);
            $em->persist($shareRecord);
        }

        $em->flush();
    }
}
