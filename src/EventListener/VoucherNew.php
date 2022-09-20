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
use App\Entity\Choice;

class VoucherNew extends AbstractController
{
    public function prePersist(Voucher $voucher, LifecycleEventArgs $event): void
    {
        // only if its
        if ($voucher->getType() == Choice::VOUCHER_TYPES['内部调控']) {
            $org = $voucher->getOrg();
            $org->setVoucher($org->getVoucher() + $voucher->getVoucher());
        }
    }

    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
    }
}
