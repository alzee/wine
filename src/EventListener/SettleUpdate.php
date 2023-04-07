<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Settle;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::preUpdate, entity: Settle::class)]
class SettleUpdate
{
    public function preUpdate(Settle $settle, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('status')) {
            if ($settle->getStatus() === 1)
                $settle->setSettledAt(new \DateTimeImmutable());
        }
    }
}
