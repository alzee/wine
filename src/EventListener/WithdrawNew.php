<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Withdraw;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class WithdrawNew extends AbstractController
{

    public function prePersist(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        if ($this->isGranted('ROLE_RESTAURANT')) {
            $withdraw->setActualAmount($withdraw->getAmount() * $withdraw->getApplicant()->getDiscount());
        } else {
            $withdraw->setActualAmount($withdraw->getAmount());
        }
    }
}
