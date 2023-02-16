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
        $snStart = $batch->getSnStart();
        $snEnd = $batch->getSnEnd();
        $qty = $batch->getQty();
        $type = $batch->getType();
        $enc = new Enc();
        $batchPrizes = $batch->getBatchPrizes();
        $prizes = [];
        foreach ($batchPrizes as $v) {
            for ($i = 0; $i < $v->getQty(); $i++) {
                $prizes[] = $v->getPrize();
            }
        }
        
        // Batch properties start
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
        // Batch properties end
        
        // Create boxes
        if ($type === 0) {
            for ($i = 0; $i < $qty; $i++) {
                $box = new Box;
                $boxSn = Sn::toSn($start + $i);
                $box->setSn($boxSn);
                $box->setCipher($enc->enc($boxSn));
                $box->setBatch($batch);
                $box->setBid($start + $i);
                $em->persist($box);
                
                // Create bottles;
                shuffle($prizes);
                for ($j = 1; $j <= $batch->getBottleQty(); $j++) {
                    $bottleSn = $boxSn . '.' . $j;
                    $bottle = new Bottle;
                    $bottle->setBid($j);
                    $bottle->setSn($bottleSn);
                    $bottle->setCipher($enc->enc($bottleSn));
                    $bottle->setPrize($prizes[$j - 1]);
                    $bottle->setBox($box);
                    $em->persist($bottle);
                }
            }
        }
        
        // Update bottles prizes;
        /**
         * Note: bottleQty MUST NOT change after create
         */
        if ($type === 1) {
            $boxes = $em->getRepository(Box::class)->findBetween($start, $start + $qty - 1);
            if (! is_null($boxes)) {
                foreach ($boxes as $box) {
                    // update box
                    $box->setBatch($batch);
                    
                    // update bottles prize
                    shuffle($prizes);
                    for ($j = 1; $j <= $batch->getBottleQty(); $j++) {
                        $bottle->setPrize($prizes[$j - 1]);
                    }
                    
                }
            }
        }
    }
}
