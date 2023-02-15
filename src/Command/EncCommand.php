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
use App\Service\Enc;

#[AsCommand(
    name: 'app:enc',
    description: 'Text enc',
)]
class EncCommand extends Command
{
    private $enc;

    public function __construct(Enc $enc)
    {
        $this->enc = $enc;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('string', InputArgument::REQUIRED, 'String to encrypt/decrypt')
            ->addOption('decrypt', 'd', InputOption::VALUE_NONE, 'Decrypt')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $string = $input->getArgument('string');

        if ($string) {
            // $io->note(sprintf('You passed an argument: %s', $string));
        }

        if ($input->getOption('decrypt')) {
            $io->info($this->enc->dec($string));
        } else {
            $io->info($this->enc->enc($string));
        }

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');


        return Command::SUCCESS;
    }
}
