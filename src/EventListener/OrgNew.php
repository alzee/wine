<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Voucher;
use App\Entity\Org;

class OrgNew extends AbstractController
{
    public function prePersist(Org $org, LifecycleEventArgs $event): void
    {
        if (is_null($org->getUpstream())) {
            // Inherit upstream's industry
        } else if (! is_null($org->getUpstream()->getIndustry()) && is_null($org->getIndustry())) {
            $org->setIndustry($org->getUpstream()->getIndustry());
        }
    }
}
