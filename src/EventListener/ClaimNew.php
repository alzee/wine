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
            
            $voucher = new Voucher();
            $voucher->setOrg($store);
            $voucher->setVoucher($toStore);
            $voucher->setType(14);
            $em->persist($voucher);
            $store->setVoucher($store->getVoucher() + $toStore);
            
            $claim->setStatus(1);
        }
       
        // Voucher random
        if ($label === 'voucher_rand') {
            $amount = rand($prize->getValue(), $prize->getValue2()) * 100;
            $voucher = new Voucher();
            $voucher->setOrg($orgCustomer);
            $voucher->setCustomer($customer);
            $voucher->setVoucher($amount);
            $voucher->setType(15);
            $em->persist($voucher);
            $customer->setVoucher($customer->getVoucher() + $amount);
            $claim->setValue($amount);
            $claim->setStatus(1);
        }
       
        // wx
        if ($label === 'wx') {
            // new withdraw to directly wx balance
            // or
            $customer->setWithdrawable($customer->getWithdrawable() + $toCustomer);
            $store->setWithdrawable($store->getWithdrawable() + $toStore);
            
            $claim->setStatus(1);
        }
       
        // wx random
        if ($label === 'wx_rand') {
            $amount = rand($prize->getValue(), $prize->getValue2()) * 100;
            $customer->setWithdrawable($customer->getWithdrawable() + $amount);
            $claim->setValue($amount);
            $claim->setStatus(1);
        }
        
        // if ($label === 'collect') {
        // }
        // 
        // if ($label === 'onemore') {
        // }
       
        $em->flush();
    }
}
