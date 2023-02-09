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
use App\Entity\User;
use App\Entity\Voucher;
use App\Entity\Scan;
use App\Entity\Withdraw;
use App\Entity\Retail;
use App\Entity\RetailReturn;
use App\Entity\OrderRestaurant;

#[AsCommand(
    name: 'app:to-customer',
    description: 'Set customer column according to consumer column',
)]
class ToCustomerCommand extends Command
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

        $classes = [
            Voucher::class,
            Scan::class,
            Withdraw::class,
            Retail::class,
            RetailReturn::class,
            OrderRestaurant::class
        ];
        foreach ($classes as $class) {
            $all = $this->em->getRepository($class)->findAll();
            foreach ($all as $instance) {
                $consumer = $instance->getConsumer();
                if (! is_null($consumer)) {
                    $customer = $this->em->getRepository(User::class)->findOneBy(['openid' => $consumer->getOpenid()]);
                    $instance->setCustomer($customer);
                }
            }
            $io->info($class . ' DONE.');
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}
