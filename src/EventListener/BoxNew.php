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
#[AsEntityListener(event: Events::postPersist, entity: Box::class)]
class BoxNew extends AbstractController
{
    public function prePersist(Box $box, LifecycleEventArgs $event): void
    {
    }

    public function postPersist(Box $box, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $qty = $box->getQuantity();
        $bqty = $box->getBottleQty();
        
        for ($i = 1; $i < $qty; $i++) {
            $b = new Box;
            $b->setQuantity(1);
            $em->persist($b);
        }
        
        $enc = new Enc();
        $id = $box->getId();
        $sn = Sn::gen($id);
        $cipher = $enc->enc($sn);
        $box->setSn($sn);
        $box->setEnc($cipher);

        for ($i = 1; $i <= $bqty; $i++) {
            $bottle = new Bottle;
            $bottle_sn = $sn . $i;
            $bottle_cipher = $enc->enc($bottle_sn);
            $bottle->setBox($box);
            $bottle->setSn($bottle_sn);
            $bottle->setEnc($bottle_cipher);
            $em->persist($bottle);
        }
        
        $em->flush();
    }
}
