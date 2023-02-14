<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Batch;
use App\Entity\Bottle;
use App\Service\Sn;
use App\Service\Enc;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Batch::class)]
class BatchNew extends AbstractController
{
    public function prePersist(Batch $batch, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $last = $em->getRepository(Batch::class)->findLast();
        $qty = $batch->getQty();
        if (is_null($last)) {
            $start = 1;
        } else if (is_null($last->getStart()) || is_null($last->getQty())) {
            // $em->remove($last);
            // $em->remove($batch);
            // return;
        } else {
            $start = $last->getStart() + $last->getQty();
        }
        $batch->setStart($start);
    }
}
