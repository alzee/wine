<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Claim;
use App\Service\Sms;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:checkExpiry',
    description: 'Check claims expiry',
)]
class CheckExpiryCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
        
        $claims = $this->em->getRepository(Claim::class)->findBy(['status' => 0]);
        
        $now = new \DateTimeImmutable('now');
        
        foreach ($claims as $c) {
            $prize = $c->getPrize();
            $expiry = $prize->getExpire();
            $createdAt = $c->getCreatedAt();
            $daysPassed = $createdAt->diff($now)->d;
            
            $daysLeft = $expiry - $daysPassed;
            
            if ($daysLeft <= 0) {
                // set expired;
                $c->setStatus(2);
                $this->em->flush();
            } else {
                $dueDate = $createdAt->modify(+$expiry . 'days');
                if ($daysPassed % 7 === 0) {
                    // sms every 7 days
                    $this->sms->send($phone, 'expiry', ['prize' => $prizeInfo, 'expiry' => $dueDate]);
                } else if ($daysLeft <= 3) {
                    // sms every day in last 3 days
                    $this->sms->send($phone, 'expiry', ['prize' => $prizeInfo, 'expiry' => $dueDate]);
                }
            }
        }
        
        // $io->success('DONE.');

        return Command::SUCCESS;
    }
}
