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
use App\Entity\Collect;
use App\Entity\Transaction;
use App\Service\Sms;
use App\Service\Wx;

#[AsEntityListener(event: Events::postPersist, entity: Retail::class)]
class RetailNew extends AbstractController
{
    private $sms;
    private $wx;
    
    public function __construct(Sms $sms, Wx $wx)
    {
        $this->sms = $sms;
        $this->wx = $wx;
    }
    
    public function postPersist(Retail $retail, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $product = $retail->getProduct();
        $quantity = $retail->getQuantity();
        $amount = $quantity * $product->getPrice() / $product->getBottleQty();
        $store = $retail->getStore();
        $customer = $retail->getCustomer();

        $retail->setAmount($amount);

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
            
            $transaction = new Transaction();
            $transaction->setUser($referrer);
            $transaction->setType(0);
            $transaction->setAmount($reward);
            $em->persist($transaction);
        }

        // org_ref_rewards begin
        // Reward store's referrer
        $referrer = $store->getReferrer();
        $reward = $product->getStoreRefReward() * $quantity;
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
            
            $transaction = new Transaction();
            $transaction->setUser($referrer);
            $transaction->setType(2);
            $transaction->setAmount($reward);
            $em->persist($transaction);
        }

        // Reward agency's referrer
        $agency = $store->getUpstream();
        $referrer = $agency->getReferrer();
        $reward = $product->getAgencyRefReward() * $quantity;
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
            
            $transaction = new Transaction();
            $transaction->setUser($referrer);
            $transaction->setType(1);
            $transaction->setAmount($reward);
            $em->persist($transaction);
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
                
                $transaction = new Transaction();
                $transaction->setUser($referrer);
                $transaction->setType(1);
                $transaction->setAmount($reward);
                $em->persist($transaction);
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
            
            $transaction = new Transaction();
            $transaction->setOrg($store);
            $transaction->setType(12);
            $transaction->setAmount($share);
            $em->persist($transaction);

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
            
            $transaction = new Transaction();
            $transaction->setOrg($variantAgency);
            $transaction->setType(11);
            $transaction->setAmount($share);
            $em->persist($transaction);

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
            
            $transaction = new Transaction();
            $transaction->setOrg($variantHead);
            $transaction->setType(10);
            $transaction->setAmount($share);
            $em->persist($transaction);
        }
        // share end
        
        // update bottle status
        $bottle = $retail->getBottle();
        $bottle->setCustomer($customer);
        $bottle->setStatus(1);
        // update box BottleSold
        $box = $bottle->getBox();
        $box->setBottleSold($box->getBottleSold() + 1);
        
        // claim
        $prize = $bottle->getPrize();
        $toStore = $prize->getToStore();
        if ($prize->getLabel() !== 'collect') {
            $claim = new Claim();
            $claim->setBottle($bottle);
            $claim->setRetail($retail);
            $claim->setCustomer($customer);
            $claim->setPrize($prize);
            if ($toStore !== 0) {
                $claim->setStore($store);
            }
            $claim->setProduct($product);
            $claim->setStatus(0);
            $em->persist($claim);
            // Why is this necessary?
            $retail->setClaim($claim);
        } else {
            // find user's collect of this product
            $collect = $em->getRepository(Collect::class)->findOneBy(['customer' => $customer, 'product' => $product]);
            if (is_null($collect)) {
                // new collect if not found
                $collect = new Collect();
                $collect->setCustomer($customer);
                $collect->setProduct($product);
                $em->persist($collect);
            } else {
                $collect->setQty($collect->getQty() + 1);
            }
            
            if ($toStore !== 0) {
                // find store's collect of this product
                $collect = $em->getRepository(Collect::class)->findOneBy(['store' => $store, 'product' => $product]);
                if (is_null($collect)) {
                    // new collect if not found
                    $collect = new Collect();
                    $collect->setStore($store);
                    $collect->setProduct($product);
                    $em->persist($collect);
                } else {
                    $collect->setQty($collect->getQty() + 1);
                }
            }
        }
        
        $em->flush();
        
        // sms to customer
        $phone = $customer->getPhone();
        $prizeInfo = $prize->getName() . ' ' . $prize->getToCustomer() / 100;
        $url_claim_customer = $this->wx->genUrlLink('myClaim', 'type=user');
        $path = ltrim($url_claim_customer, 'https://wxaurl.cn/');
        if (! is_null($phone)) {
            $this->sms->send($phone, 'customer_draw', ['prize' => $prizeInfo, 'path' => $path]);
        }
        
        if ($toStore !== 0) {
            // sms to store
            $phone = $store->getPhone();
            $prizeInfo = $prize->getName() . ' ' . $toStore / 100;
            $url_claim_store = $this->wx->genUrlLink('myClaim', 'type=store');
            $path = ltrim($url_claim_store, 'https://wxaurl.cn/');
            if (! is_null($phone)) {
                $this->sms->send($phone, 'store_draw', ['prize' => $prizeInfo, 'path' => $path]);
            }
        }
    }
}
