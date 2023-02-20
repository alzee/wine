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
        $customer = $claim->getCustomer();
        $orgCustomer = $em->getRepository(Org::class)->findOneByType(4);
        
        $pid = $prize->getId();
        
        // Voucher
        if ($pid === 3) {
            $amount = $prize->getValue() * 100;
            $voucher = new Voucher();
            $voucher->setOrg($orgCustomer);
            $voucher->setCustomer($customer);
            $voucher->setVoucher($amount);
            $voucher->setType(14);
            $em->persist($voucher);
            $customer->setVoucher($customer->getVoucher() + $amount);
            $claim->setStatus(1);
        }
       
        // Voucher random
        if ($pid === 4) {
            $amount = rand($prize->getValue(), $prize->getValue2()) * 100;
            $voucher = new Voucher();
            $voucher->setOrg($orgCustomer);
            $voucher->setCustomer($customer);
            $voucher->setVoucher($amount);
            $voucher->setType(15);
            $em->persist($voucher);
            $customer->setVoucher($customer->getVoucher() + $amount);
            $claim->setStatus(1);
        }
       
        // wx
        if ($pid === 5) {
            $amount = $prize->getValue() * 100;
            $customer->setWithdrawable($customer->getWithdrawable() + $amount);
            $claim->setStatus(1);
        }
       
        // wx random
        if ($pid === 6) {
            $amount = rand($prize->getValue(), $prize->getValue2()) * 100;
            $customer->setWithdrawable($customer->getWithdrawable() + $amount);
            $claim->setStatus(1);
        }
       
        $em->flush();
    }
}
