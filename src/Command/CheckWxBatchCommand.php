<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WxPay;

#[AsCommand(
    name: 'app:check-wx-batch',
    description: 'Check wx batch id',
)]
class CheckWxBatchCommand extends Command
{
    private $wxpay;

    public function __construct(WxPay $wxpay)
    {
        $this->wxpay = $wxpay;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('batchid', InputArgument::REQUIRED, 'wxpay batch id')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('batchid');

        if ($id) {
            // $io->note(sprintf('You passed an argument: %s', $boxid));
        }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $this->wxpay->checkBatch($id);
        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
