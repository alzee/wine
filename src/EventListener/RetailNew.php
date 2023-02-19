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
use App\Entity\Reward;
use App\Entity\Share;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use App\Entity\Bottle;
use App\Entity\Claim;

#[AsEntityListener(event: Events::postPersist, entity: Retail::class)]
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
        $customer = $retail->getCustomer();

        $retail->setAmount($amount);
        $retail->setVoucher($voucher);

        // store stock - quantity
        $stockRecord = $em->getRepository(Stock::class)->findOneBy(['org' => $store, 'product' => $product]);
        $stockRecord->setStock($stockRecord->getStock() - $quantity);

        // customer + voucher
        $customer->setVoucher($customer->getVoucher() + $voucher);

        // store - voucher
        $store->setVoucher($store->getVoucher() - $voucher);

        // voucher record for store
        $record = new Voucher();
        $record->setOrg($store);
        $record->setVoucher(-$voucher);
        $type = Choice::VOUCHER_TYPES['酒零售'];
        $record->setType($type);
        $em->persist($record);

        // voucher record for customer
        $record = new Voucher();
        $consumers = $em->getRepository(Org::class)->findOneByType(4);
        $record->setOrg($consumers);
        $record->setCustomer($customer);
        $record->setVoucher($voucher);
        $record->setType($type - 100);
        $em->persist($record);

        // Reward customer's referrer
        $referrer = $customer->getReferrer();
        if (! is_null($referrer)) {
            $reward = $product->getRefReward() * $quantity;
            $referrer->setWithdrawable($referrer->getWithdrawable() + $reward);
            $rewardRecord = new Reward();
            $rewardRecord->setType(6);
            $rewardRecord->setRetail($retail);
            $rewardRecord->setReferrer($referrer);
            $rewardRecord->setAmount($reward);
            $em->persist($rewardRecord);
        }

        // org_ref_rewards begin
        $reward = $product->getOrgRefReward() * $quantity;
        // Reward store's referrer
        $referrer = $store->getReferrer();
        if (! is_null($referrer)) {
            $referrer->setWithdrawable($referrer->getWithdrawable() + $reward);
            $rewardRecord = new Reward();
            // store
            if ($store->getType() == 2) {
                $rewardRecord->setType(3);
            }
            // variant_store
            if ($store->getType() == 12) {
                $rewardRecord->setType(4);
            }
            // restaurant
            if ($store->getType() == 3) {
                $rewardRecord->setType(5);
            }
            $rewardRecord->setRetail($retail);
            $rewardRecord->setReferrer($referrer);
            $rewardRecord->setAmount($reward);
            $em->persist($rewardRecord);
        }

        // Reward agency's referrer
        $agency = $store->getUpstream();
        $referrer = $agency->getReferrer();
        if (! is_null($referrer)) {
            $referrer->setWithdrawable($referrer->getWithdrawable() + $reward);
            $rewardRecord = new Reward();
            // agency
            if ($agency->getType() == 1) {
                $rewardRecord->setType(0);
            }

            // variant_agency
            if ($agency->getType() == 11) {
                $rewardRecord->setType(2);
            }
            $rewardRecord->setRetail($retail);
            $rewardRecord->setReferrer($referrer);
            $rewardRecord->setAmount($reward);
            $em->persist($rewardRecord);
        }

        // variant_head
        if ($agency->getType() == 11) {
            $variantHead = $agency->getUpstream();
            $referrer = $variantHead->getReferrer();
            if (! is_null($referrer)) {
                $referrer->setWithdrawable($referrer->getWithdrawable() + $reward);
                $rewardRecord = new Reward();
                $rewardRecord->setType(1);
                $rewardRecord->setRetail($retail);
                $rewardRecord->setReferrer($referrer);
                $rewardRecord->setAmount($reward);
                $em->persist($rewardRecord);
            }
        }
        // org_ref_rewards end

        // share begin
        if ($store->getType() == 12) {
            // variantStoreShare
            $share = $product->getVariantStoreShare() * $quantity;
            $store->setWithdrawable($store->getWithdrawable() + $share);
            $shareRecord = new Share();
            $shareRecord->setType(0);
            $shareRecord->setRetail($retail);
            $shareRecord->setOrg($store);
            $shareRecord->setAmount($share);
            $em->persist($shareRecord);

            // variantAgencyShare
            $share = $product->getVariantAgencyShare() * $quantity;
            $variantAgency = $store->getUpstream();
            $variantAgency->setWithdrawable($variantAgency->getWithdrawable() + $share);
            $shareRecord = new Share();
            $shareRecord->setType(1);
            $shareRecord->setRetail($retail);
            $shareRecord->setOrg($variantAgency);
            $shareRecord->setAmount($share);
            $em->persist($shareRecord);

            // variantHeadShare
            $share = $product->getVariantHeadShare() * $quantity;
            $variantHead = $variantAgency->getUpstream();
            $variantHead->setWithdrawable($variantHead->getWithdrawable() + $share);
            $shareRecord = new Share();
            $shareRecord->setType(2);
            $shareRecord->setRetail($retail);
            $shareRecord->setOrg($variantHead);
            $shareRecord->setAmount($share);
            $em->persist($shareRecord);
        }
        // share end
        
        // update bottle status
        $bottle = $retail->getBottle();
        $bottle->setCustomer($customer);
        $bottle->setStatus(1);
        
        // claim
        $prize = $bottle->getPrize();
        if (! in_array($prize->getId(), [7, 8])) {
            $claim = new Claim();
            $claim->setBottle($bottle);
            $claim->setRetail($retail);
            $claim->setCustomer($customer);
            $claim->setPrize($prize);
            $claim->setStatus(0);
            $em->persist($claim);
        }

        if ($prize->getId() === 7) {
            $customer->setPoint($customer->getPoint() + 100);
        }
        
        $em->flush();
    }
}
