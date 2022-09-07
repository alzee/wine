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

class UserNew extends AbstractController
{
    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $org = $user->getOrg();
        $role = match ($org->getType()) {
            0 => 'HEAD',
            1 => 'AGENCY',
            2 => 'STORE',
            3 => 'RESTAURANT',
        };

        $user->setRoles(['ROLE_' . $role]);

        $em->flush();
    }
}
