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
    public function preUpdate(Reward $reward, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('status')) {
            $em = $event->getEntityManager();
            $newStatusId = $event->getNewValue('status')->getId();
            if ($newStatusId == 1) {
                $referrer = $reward->getReferrer();
                $amount = $reward->getAmount();
                $referrer->setWithdrawable($referrer->getWithdrawable() + $amount);
            }
        }
    }
}
