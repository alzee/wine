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
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postUpdate, entity: Share::class)]
class ShareUpdate
{
    public function postUpdate(Share $share, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($share);
        if (isset($changeSet['status'])) {
            $status = $share->getStatus();
            if ($status == 1) {
                $org = $share->getOrg();
                $amount = $share->getAmount();
                $org->setWithdrawable($org->getWithdrawable() + $amount);
                $org->setShare($org->getShare() - $amount);
                $em->flush();
            }
        }
    }
}
