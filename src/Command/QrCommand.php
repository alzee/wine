<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\Qr;

#[AsCommand(
    name: 'app:qr',
    description: 'Add a short description for your command',
)]
class QrCommand extends Command
{
    private $qr;

    public function __construct(Qr $qr)
    {
        $this->qr = $qr;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('boxid', InputArgument::REQUIRED, 'Box id')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $boxid = $input->getArgument('boxid');

        if ($boxid) {
            // $io->note(sprintf('You passed an argument: %s', $boxid));
        }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        $this->qr->pack($boxid);

        return Command::SUCCESS;
    }
}
