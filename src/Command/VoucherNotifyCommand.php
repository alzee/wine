<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use App\Service\Sms;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:voucherNotify',
    description: 'Notify if user has voucher more than <threshold>',
)]
class VoucherNotifyCommand extends Command
{
    private $em;
    private $sms;

    public function __construct(EntityManagerInterface $em, Sms $sms)
    {
        $this->em = $em;
        $this->sms = $sms;
        parent::__construct();
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('threshold', InputArgument::REQUIRED, 'min voucher value')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $threshold = $input->getArgument('threshold') * 100;

        if ($threshold) {
            $users = $this->em->getRepository(User::class)->findVoucherMoreThan($threshold);
            foreach ($users as $u) {
                $phone = $u->getPhone();
                if (!is_null($phone)) {
                    $this->sms->send($phone, 'voucher_notify', ['voucher' => $u->getVoucher() / 100]);
                }
            }
        }

        // $io->success('DONE.');

        return Command::SUCCESS;
    }
}
