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
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user, LifecycleEventArgs $event): void
    {
        $user->setPassword($this->hasher->hashPassword($user, $user->getPlainPassword()));
        $user->eraseCredentials();

        // If not set any role for user, he will get ONE role ROLE_USER
        if (count($user->getRoles()) == 1) {
            // Only give user one of these roles if no roles have set
            $role = match ($user->getOrg()->getType()) {
                0 => 'HEAD',
                1 => 'AGENCY',
                2 => 'STORE',
                3 => 'RESTAURANT',
                10 => 'VARIANT_HEAD',
                11 => 'VARIANT_AGENCY',
                12 => 'VARIANT_STORE',
            };
            $user->setRoles(['ROLE_' . $role]);
        }
    }

    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
        // $em = $event->getEntityManager();
        // $em->flush();
    }
}
