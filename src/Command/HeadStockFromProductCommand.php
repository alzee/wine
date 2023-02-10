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
use App\Entity\Product;
use App\Entity\Stock;
use App\Entity\Org;

#[AsCommand(
    name: 'app:head-stock-from-product',
    description: 'Add stock records of head from product',
)]
class HeadStockFromProductCommand extends Command
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

        $head = $this->em->getRepository(Org::class)->findOneBy(['type' => 0]);
        $products = $this->em->getRepository(Product::class)->findAll();

        foreach ($products as $p) {
            $stockRecord = $this->em->getRepository(Stock::class)->findOneBy(['org' => $head, 'product' => $p]);
            if (is_null($stockRecord)) {
                $stockRecord = new Stock();
                $stockRecord->setStock(99999);
                $stockRecord->setOrg($head);
                $stockRecord->setProduct($p);
                $this->em->persist($stockRecord);
            }
        }

        $this->em->flush();

        $io->success('DONE.');

        return Command::SUCCESS;
    }
}
