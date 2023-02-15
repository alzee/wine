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
        $enc = new Enc();
        
        // if (is_null($snStart)) {
        if ($type === 0) {
            $lastBox = $em->getRepository(Box::class)->findLast();
            if (is_null($lastBox)) {
                $start = 1;
            } else {
                $start = $lastBox->getId() + 1;
            }
            $batch->setStart($start);
            $batch->setSnStart(Sn::toSn($start));
            $batch->setSnEnd(Sn::toSn($start + $qty - 1));
        } 
        
        if ($type === 1) { 
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
            // if both snEnd and qty are given, use snEnd
            if ($qty !== Sn::toId($snEnd) - $start + 1) {
                $qty = Sn::toId($snEnd) - $start + 1;
            }
        }
        
        if ($type === 0) {
            for ($i = 0; $i < $qty; $i++) {
                $box = new Box;
                $box->setSn(Sn::toSn($start + $i));
                $ciphers = [ $enc->enc($start + $i) ];
                for ($j = 1; $j <= $batch->getBottleQty(); $j++) {
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
                    // update prizes
                    $prizes = range(1, $batch->getBottleQty());
                    shuffle($prizes);
                    $box->setPrize($prizes);
                    
                    // update ciphers
                    $ciphers = [ $enc->enc($box->getId()) ];
                    for ($i = 1; $i <= $batch->getBottleQty(); $i++) {
                        $ciphers[] = $enc->enc($box->getId() . '.' . $i);
                    }
                    $box->setCipher($ciphers);
                     
                    $box->setBatch($batch);
                }
            }
        }
    }
}
