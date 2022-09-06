<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Orders;
use App\Entity\Product;
use App\Entity\Org;
use App\Entity\Withdraw;

class WithdrawUpdate
{
    public function postUpdate(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($withdraw);
        $status = $withdraw->getStatus();

        if (isset($changeSet['status'])) {
            if ($status == 5) {
                $amount = $withdraw->getAmount();
                // applicant's voucher - amount
                $applicant = $withdraw->getOrg();
                $applicant->setVoucher($applicant->getVoucher() - $amount);

                // if applicant is a store
                // if it's an agency, no need to add amount to headquarter
                if ( $applicant->getType() == 2) {
                    // reviewer's voucher + amount
                    // $agency = '';
                    // $agency->setVoucher($agency->getVoucher() - $amount);
                }
            }
            $em->flush();
        }

    }
}
