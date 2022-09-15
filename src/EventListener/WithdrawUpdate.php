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
use App\Entity\Voucher;

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
                $applicant = $withdraw->getApplicant();
                $applicant->setVoucher($applicant->getVoucher() - $amount);

                // voucher record for applicant
                $record = new Voucher();
                $record->setOrg($applicant);
                $record->setVoucher(-$amount);
                $type = match ($applicant->getType()) {
                    1 => 14,
                    2 => 15,
                };
                $record->setType($type);
                $em->persist($record);

                // stores don't withdraw
                // if it's an agency, no need to add amount to headquarter
                // so just need to think about restaurant
                if ( $applicant->getType() == 3) {
                    $approver = $withdraw->getApprover();
                    $approver->setVoucher($agency->getVoucher() + $amount);

                    // voucher record for approver
                    $record = new Voucher();
                    $record->setOrg($approver);
                    $record->setVoucher($amount);
                    $record->setType($type - 10);
                    $em->persist($record);
                }

                $em->flush();
            }
        }

    }
}
