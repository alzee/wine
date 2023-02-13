<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Code;
use App\Service\Enc;
use App\Service\Sn;

#[AsCommand(
    name: 'app:gen-code',
    description: 'Genarate product codes',
)]
class GenCodeCommand extends Command
{
    private $em;
    private $enc;

    public function __construct(Enc $enc, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->enc = $enc;

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

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        // $io->info(Sn::gen(100000));
        $enc = new Enc;
        dump($enc->dec('lx0JnYM3JqoCrQ==.FODoQ7az3T/yrGp7.oENgbCP3E7/PvgkQLGEiXQ=='));
        return Command::SUCCESS;
    }
}
