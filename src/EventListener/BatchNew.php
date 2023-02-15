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
use App\Entity\Box;
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
        $snStart = $batch->getSnStart();
        $snEnd = $batch->getSnEnd();
        $qty = $batch->getQty();
        $type = $batch->getType();
        
        if (is_null($snStart)) {
            $lastBox = $em->getRepository(Box::class)->findLast();
            if (is_null($lastBox)) {
                $start = 1;
            } else {
                $start = $lastBox->getId() + 1;
            }
            $batch->setStart($start);
            $batch->setSnStart(Sn::toSn($start));
            $batch->setSnEnd(Sn::toSn($start + $qty - 1));
        } else {
            $start = Sn::toId($snStart);
            $batch->setStart($start);
            if (is_null($qty)) {
                $qty = Sn::toId($snEnd) - $start + 1;
                $batch->setQty($qty);
            }
            if (is_null($snEnd)) {
                $snEnd = Sn::toSn($start + $qty - 1);
                $batch->setSnEnd($snEnd);
            }
        }
        
        if ($type === 0) {
            $enc = new Enc();
            for ($i = 0; $i < $qty; $i++) {
                $box = new Box;
                $box->setSn(Sn::toSn($start + $i));
                $ciphers = [ $enc->enc($start + $i) ];
                for ($j = 0; $j < $batch->getBottleQty(); $j++) {
                    $ciphers[] = $enc->enc($start + $i . '.' . $j);
                }
                $prizes = range(1, $batch->getBottleQty());
                shuffle($prizes);
                $box->setCipher($ciphers);
                $box->setPrize($prizes);
                $box->setBatch($batch);
                $em->persist($box);
            }
        }
        
        if ($type === 1) {
            $boxes = $em->getRepository(Box::class)->findBetween($start, $start + $qty - 1);
            if (! is_null($boxes)) {
                foreach ($boxes as $box) {
                    $box->setBatch($batch);
                }
            }
        }
    }
}
