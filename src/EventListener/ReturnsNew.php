<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Returns;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Product;
use App\Entity\Voucher;
use App\Entity\Choice;
use App\Entity\Stock;
use Doctrine\DBAL\Exception\DriverException;
use App\Entity\Reward;

class ReturnsNew extends AbstractController
{
    public function prePersist(Returns $return, LifecycleEventArgs $event): void
    {
        $amount = 0;
        $voucher = 0;

        foreach ($return->getReturnItems() as $i) {
            $product = $i->getProduct();
            $quantity = $i->getQuantity();
            $price = $product->getPrice();
            $unitVoucher = $product->getVoucher();
            // accumulate voucher
            $amount += $price * $quantity;
            // accumulate amount
            $voucher += $unitVoucher * $quantity;
        }

        $return->setAmount($amount);
        $return->setVoucher($voucher);
        $return->setStatus(5);
    }

    public function postPersist(Returns $return, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();

        $sender = $return->getSender();
        $recipient = $return->getRecipient();
        foreach ($return->getReturnItems() as $i) {
            $product = $i->getProduct();
            $quantity = $i->getQuantity();
            $sn = $product->getSn();
            $price = $product->getPrice();
            $unitVoucher = $product->getVoucher();

            // sender stock - quantity,
            $stockRecordOfSender= $em->getRepository(Stock::class)->findOneBy(['org' => $sender, 'product' => $product]);
            $stockRecordOfSender->setStock($stockRecordOfSender->getStock() - $quantity);

            // recipient stock + quantity, only if recipient is not head
            if ($recipient->getType() != 0) {
                $stockRecordOfRecipient = $em->getRepository(Stock::class)->findOneBy(['org' => $recipient, 'product' => $product]);
                $stockRecordOfRecipient->setStock($stockRecordOfRecipient->getStock() + $quantity);
            }

            $reward = $product->getOrgRefReward() * $quantity;
            $rewardRecord = new Reward();
            // Reward referrer when agency buy
            if ($sender->getType() == 1) {
                $referrer = $sender->getReferrer();
            }
            // Reward referrer when variantHead buy
            if ($sender->getType() == 10) {
                $referrer = $sender->getReferrer();
            }
            // Reward referrer when variantAgency sell
            if ($recipient->getType() == 11) {
                $referrer = $recipient->getReferrer();
            }
            if (isset($referrer) && ! is_null($referrer)) {
                $rewardRecord->setStatus(0);
                $referrer->setReward($referrer->getReward() - $reward);
                $rewardRecord->setReferrer($referrer);
                $rewardRecord->setAmount($reward);
                $rewardRecord->setRet($return);
                $rewardRecord->setType(6);
                $em->persist($rewardRecord);
            }
        }

        $voucher = $return->getVoucher();
        // sender voucher - voucher
        $sender->setVoucher($sender->getVoucher() - $voucher);

        // recipient voucher + voucher
        $recipient->setVoucher($recipient->getVoucher() + $voucher);

        // voucher record for sender
        $record = new Voucher();
        $record->setOrg($sender);
        $record->setVoucher(-$voucher);
        $type = Choice::VOUCHER_TYPES['退货发出'];
        $record->setType($type);
        $em->persist($record);

        // voucher record for recipient 
        $record = new Voucher();
        $record->setOrg($recipient);
        $record->setVoucher($voucher);
        $record->setType($type - 100);
        $em->persist($record);

        $em->flush();
    }
}
