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
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use App\Service\WxPay;

#[AsEntityListener(event: Events::postUpdate, entity: Withdraw::class)]
class WithdrawUpdate
{
    private $wxpay;

    public function __construct(WxPay $wxpay)
    {
        $this->wxpay = $wxpay;
    }

    public function postUpdate(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($withdraw);
        $status = $withdraw->getStatus();

        if (isset($changeSet['status'])) {
            $amount = $withdraw->getAmount();
            $applicant = $withdraw->getApplicant();
            if (is_null($applicant)) {
                $applicant = $withdraw->getCustomer();
            }

            if ($status == 5) {
                // in case have more than one withdraw application at same time
                $applicant->setWithdrawing($applicant->getWithdrawing() - $amount);
                // or
                // $applicant->setWithdrawing(0);
                
                if (! is_null($applicant)) {
                    // WxPay require out_batch_no to be string and length > 5
                    $id = 'wx' . str_pad($withdraw->getId(), 18, 0, STR_PAD_LEFT);
                    $batch = [
                        'id' => $id,
                        'name' => $applicant->getName() . 'withdraw',
                        'note' => $applicant->getName() . 'withdraw note',
                        'amount' => $amount,
                        // 'scene' => 1000
                    ];
                    $list = [
                        [
                            'out_detail_no' => $id,
                            'transfer_amount' => $amount,
                            'transfer_remark' => '老酒库现金奖励',
                            'openid' => $applicant->getOpenid(),
                        ]
                    ];
                    $resp = $this->wxpay->toBalanceBatch($batch, $list);
                    $withdraw->setWxBatchId($resp['batch_id']);
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
