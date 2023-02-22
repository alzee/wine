<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Withdraw;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Org;
use App\Service\WxPay;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Withdraw::class)]
#[AsEntityListener(event: Events::postPersist, entity: Withdraw::class)]
class WithdrawNew extends AbstractController
{
    private $wxpay;

    public function __construct(WxPay $wxpay)
    {
        $this->wxpay = $wxpay;
    }

    public function prePersist(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $head = $em->getRepository(Org::class)->findOneBy(['type' => 0]);
        $amount = $withdraw->getAmount();
        $withdraw->setActualAmount($withdraw->getAmount());
        $withdraw->setApprover($head);

        $applicant = $withdraw->getApplicant();
        if (! is_null($applicant)) {
            if ($applicant->getType() == 1 || $applicant->getType() == 3) {
                $withdraw->setApprover($applicant->getUpstream());
            }

            if ($applicant->getType() == 3) {
                $withdraw->setActualAmount($withdraw->getAmount() * $applicant->getDiscount());
            }
        } else {
            $applicant = $withdraw->getCustomer();
        }

        $applicant->setWithdrawable($applicant->getWithdrawable() - $amount);
        $applicant->setWithdrawing($applicant->getWithdrawing() + $amount);
    }

    public function postPersist(Withdraw $withdraw, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $customer = $withdraw->getCustomer();
        $amount = 1;
        if (! is_null($customer)) {
            $id = 'fuckwx' . str_pad($withdraw->getId(), 9, 0, STR_PAD_LEFT); // WxPay require out_batch_no to be string and length > 5
            $batch = [
                'id' => $id, // WxPay require out_batch_no to be string and length > 5
                'name' => $customer->getName() . 'withdraw',
                'note' => $customer->getName() . 'withdraw note',
                'amount' => $amount,
                // 'scene' => 1000
            ];
            $list = [
                [
                    'out_detail_no' => $id,
                    'transfer_amount' => $amount,
                    'transfer_remark' => 'I want money.',
                    'openid' => $customer->getOpenid(),
                ]
            ];
            $this->wxpay->toBalanceBatch($batch, $list);
        }

        // $em->persist($record);
        // $em->flush();
    }
}
