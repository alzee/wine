<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Share;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ShareUpdate
{
    public function preUpdate(Share $share, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('status')) {
            $em = $event->getEntityManager();
            $newStatusId = $event->getNewValue('status')->getId();
            if ($newStatusId == 1) {
                $org = $share->getOrg();
                $amount = $reward->getAmount();
                $org->setWithdrawable($org->getWithdrawable() + $amount);
            }
        }
    }
}
