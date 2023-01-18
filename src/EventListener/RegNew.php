<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reg;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Org;
use App\Service\Sms;

class RegNew extends AbstractController
{
    private $sms ;

    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
    }

    public function postPersist(Reg $reg, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $type = $reg->getType();
        switch ($type) {
            case 0:
                $org = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
                break;
            case 1:
                $org = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
                break;
            case 2:
                $org = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
                break;
            case 3:
                $org = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
                break;
            case 4:
                $org = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
                break;
        }

        $phone = $org->getPhone();

        if ($phone) {
            $this->sms->send($phone, 'verify');
        }

        $em->flush();
    }
}
