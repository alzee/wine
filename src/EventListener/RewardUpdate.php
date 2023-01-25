<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Reward;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class RewardUpdate
{
    public function postUpdate(Reward $reward, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($reward);
        if (isset($changeSet['status'])) {
            $status = $reward->getStatus();
            if ($status == 1) {
                $referrer = $reward->getReferrer();
                $amount = $reward->getAmount();
                $referrer->setWithdrawable($referrer->getWithdrawable() + $amount);
                $referrer->setReward($referrer->getReward() - $amount);
                $em->flush();
            }
        }
    }
}
