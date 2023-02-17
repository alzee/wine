<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Prize;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use App\Entity\Bottle;

#[AsEntityListener(event: Events::postUpdate, entity: Prize::class)]
class PrizeUpdate
{

    public function __construct()
    {
    }

    public function postUpdate(Prize $prize, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($prize);
        dump($changeSet);

        if (isset($changeSet['bottles']) && $prize->isBig()) {
            $bottles = $prize->getBottles();
            foreach ($bottles as $sn) {
                $bottle = $em->getRepository(Bottle::class)->findOneBy(['sn' => $sn]);
                if (! is_null($bottle)) {
                    $bottle->setPrize($prize);
                }
            }
            $em->flush();
        }
    }
}
