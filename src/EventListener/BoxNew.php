<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Box;
use App\Entity\Bottle;
use App\Service\Sn;
use App\Service\Enc;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Box::class)]
class BoxNew extends AbstractController
{
    public function prePersist(Box $box, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $last = $em->getRepository(Box::class)->findLast();
        $qty = $box->getQuantity();
        if (is_null($last)) {
            $start = 1;
        } else if (empty($last->getBoxid())) {
            // $em->remove($last);
            // $em->remove($box);
            // return;
        } else {
            $start = $last->getBoxid()[1] + 1;
        }
        $end = $start + $qty - 1;
        $boxid = [$start, $end];
        $box->setBoxid($boxid);
    }
}
