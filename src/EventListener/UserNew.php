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
use App\Entity\Org;
use App\Entity\Choice;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use App\Service\Poster;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
#[AsEntityListener(event: Events::postPersist, entity: User::class)]
class UserNew extends AbstractController
{
    private $hasher;
    private $poster;

    public function __construct(UserPasswordHasherInterface $hasher, Poster $poster)
    {
        $this->hasher = $hasher;
        $this->poster = $poster;
    }

    public function prePersist(User $user, LifecycleEventArgs $event): void
    {
        if (! is_null($user->getOpenid())) {
            $user->setUsername($user->getOpenid());
        }
        if (is_null($user->getPlainPassword())) {
            $user->setPlainPassword('111');
        }
        $user->setPassword($this->hasher->hashPassword($user, $user->getPlainPassword()));
        $user->eraseCredentials();

        if (is_null($user->getOrg())) {
            $orgCustomer = $event->getEntityManager()->getRepository(Org::class)->findOneBy(['type' => 4]);
            $user->setOrg($orgCustomer);
        }
    }

    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
        $uid = $user->getId();
        $this->poster->generate($uid);
    }
}
