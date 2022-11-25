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
        $applicant = $withdraw->getApplicant();
        $amount = $withdraw->getAmount();

        $applicant->setWithdrawable($applicant->getWithdrawable() - $amount);
        $applicant->setWithdrawing($applicant->getWithdrawing() + $amount);

        $withdraw->setApprover($applicant->getUpstream());

        if ($applicant->getType() == 3) {
            $withdraw->setActualAmount($withdraw->getAmount() * $applicant->getDiscount());
        } else {
            $withdraw->setActualAmount($withdraw->getAmount());
        }
    }
}
