<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Claim;
use App\Entity\Voucher;
use App\Entity\Withdraw;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use App\Entity\Org;
use App\Entity\Transaction;

#[AsEntityListener(event: Events::postPersist, entity: Claim::class)]
class ClaimNew extends AbstractController
{
    public function postPersist(Claim $claim, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $prize = $claim->getPrize();
        $store = $claim->getStore();
        $customer = $claim->getCustomer();
        $orgCustomer = $em->getRepository(Org::class)->findOneByType(4);
        $toCustomer = $prize->getToCustomer();
        $toStore = $prize->getToStore();
        
        $label = $prize->getLabel();
        
        // Voucher
        if ($label === 'voucher') {
            $voucher = new Voucher();
            $voucher->setOrg($orgCustomer);
            $voucher->setCustomer($customer);
            $voucher->setVoucher($toCustomer);
            $voucher->setType(14);
            $em->persist($voucher);
            $customer->setVoucher($customer->getVoucher() + $toCustomer);
            
            if ($toStore > 0) {
                // for store is cash
                $store->setWithdrawable($store->getWithdrawable() + $toStore);
                
                $transaction = new Transaction();
                $transaction->setOrg($store);
                $transaction->setType(13);
                $transaction->setAmount($toStore);
                $em->persist($transaction);
            }
            
            $claim->setStatus(1);
        }
       
        // wx
        if ($label === 'wx') {
            $customer->setWithdrawable($customer->getWithdrawable() + $toCustomer);
            
            // new withdraw to directly wx balance
            $withdraw = new Withdraw();
            $withdraw->setCustomer($customer);
            $withdraw->setAmount($toCustomer);
            $em->persist($withdraw);
            
            $transaction = new Transaction();
            $transaction->setUser($customer);
            $transaction->setType(3);
            $transaction->setAmount($toCustomer);
            $em->persist($transaction);
            
            if ($toStore > 0) {
                $store->setWithdrawable($store->getWithdrawable() + $toStore);
                
                $transaction = new Transaction();
                $transaction->setOrg($store);
                $transaction->setType(13);
                $transaction->setAmount($toStore);
                $em->persist($transaction);
            }
            
            $claim->setStatus(1);
        }
       
        $em->flush();
    }
}
