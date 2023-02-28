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
use App\Entity\Org;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Withdraw::class)]
#[AsEntityListener(event: Events::postPersist, entity: Withdraw::class)]
class WithdrawNew extends AbstractController
{
    public function prePersist(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $head = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
        $amount = $withdraw->getAmount();
        $withdraw->setActualAmount($withdraw->getAmount());
        $withdraw->setApprover($head);

        $applicant = $withdraw->getApplicant();
        if (! is_null($applicant)) {
            if ($applicant->getType() == 1 || $applicant->getType() == 3) {
                $withdraw->setApprover($applicant->getUpstream());
            }

            if ($applicant->getType() == 3) {
                $withdraw->setActualAmount($withdraw->getAmount() * $applicant->getDiscount());
            }
        } else {
            $applicant = $withdraw->getCustomer();
        }

        $applicant->setWithdrawable($applicant->getWithdrawable() - $amount);
        $applicant->setWithdrawing($applicant->getWithdrawing() + $amount);
    }

    public function postPersist(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $withdraw->setStatus(5);
        $em->flush();
    }
}
