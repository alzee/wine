<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class UserUpdate
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function preUpdate(User $user, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('plainPassword')) {
            $user->setPassword($this->hasher->hashPassword($user, $user->getPlainPassword()));
            $user->eraseCredentials();
        }

        if ($event->hasChangedField('org')) {
            $role = match ($user->getOrg()->getType()) {
                0 => 'HEAD',
                1 => 'AGENCY',
                2 => 'STORE',
                3 => 'RESTAURANT',
            };

            $user->setRoles(['ROLE_' . $role]);
        }
    }
}
