<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Voucher;
use App\Entity\Org;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class VoucherNew extends AbstractController
{
    public function prePersist(Voucher $voucher, LifecycleEventArgs $event): void
    {
        // only if its type 30
        if ($voucher->getType() == 30) {
            $org = $voucher->getOrg();
            $org->setVoucher($org->getVoucher() + $voucher->getVoucher());
        }
    }

    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
    }
}
