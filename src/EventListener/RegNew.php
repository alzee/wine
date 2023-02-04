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
use App\Entity\Choice;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, entity: Reg::class)]
class RegNew extends AbstractController
{
    private $sms ;
    private $translator;

    public function __construct(Sms $sms, TranslatorInterface $translator)
    {
        $this->sms = $sms;
        $this->translator = $translator;
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
        $name = $reg->getSubmitter()->getName();
        $type = $this->translator->trans(array_flip(Choice::REG_TYPES)[$reg->getType()]);
        $orgName = $reg->getOrgName();
        $contact = $reg->getName();
        $contactPhone = $reg->getPhone();
        $address = $reg->getAddress();

        // for testing
        $phone = '';

        if (! empty($phone)) {
            $this->sms->send($phone, 'orgReg', [
                'name' => $name,
                'type' => $type,
                'orgName' => $orgName,
                'contact' => $contact,
                'phone' => $contactPhone,
                'address' => $address
            ], true);
        }

        $em->flush();
    }
}
