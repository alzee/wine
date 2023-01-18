<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WX;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\Poster;

#[AsCommand(
    name: 'wxqr',
    description: 'Manually generate WX QR for consumer',
)]
class WxqrCommand extends Command
{
    private $poster;

    public function __construct(Poster $poster)
    {
        $this->poster = $poster;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('cid', InputArgument::REQUIRED, 'Consumer ID')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cid = $input->getArgument('cid');
        $this->poster->generate($cid);

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
