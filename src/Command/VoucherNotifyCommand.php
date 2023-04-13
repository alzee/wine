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
    description: 'Notify voucher',
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
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        
        $users = $this->em->getRepository(User::class)->findBy(['status' => 0]);
        
        foreach ($users as $u) {
            $this->sms->send($phone, 'voucher_notify', ['voucher' => $u->getVoucher() / 100]);
        }

        // $io->success('DONE.');

        return Command::SUCCESS;
    }
}
