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
use App\Entity\Choice;

class WithdrawUpdate
{
    public function postUpdate(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($withdraw);
        $status = $withdraw->getStatus();

        if (isset($changeSet['status'])) {
            $amount = $withdraw->getAmount();
            $applicant = $withdraw->getApplicant();

            if ($status == 5) {
                // in case have more than one withdraw application at same time
                $applicant->setWithdrawing($applicant->getWithdrawing() - $amount);
                // or
                // $applicant->setWithdrawing(0);

                // voucher record for applicant
                // $record = new Voucher();
                // $record->setOrg($applicant);
                // $record->setVoucher(-$amount);
                // $type = Choice::VOUCHER_TYPES['申请提现'];
                // $record->setType($type);
                // $em->persist($record);

                // stores don't withdraw
                // if it's an agency, no need to add amount to headquarter
                // so just need to think about restaurant
                if ( $applicant->getType() == 3) {
                    $approver = $withdraw->getApprover();
                    $approver->setWithdrawable($approver->getWithdrawable() + $amount);

                    // voucher record for approver
                    // $record = new Voucher();
                    // $record->setOrg($approver);
                    // $record->setVoucher($amount);
                    // $record->setType($type - 10);
                    // $em->persist($record);
                }
            }

            if ($status == 4) {
                $applicant->setWithdrawable($applicant->getWithdrawable() + $amount);
                $applicant->setWithdrawing($applicant->getWithdrawing() - $amount);
            }

            $em->flush();
        }

    }
}
