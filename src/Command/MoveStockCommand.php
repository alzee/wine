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
    name: 'moveStock',
    description: 'Move stock in product repo to stock',
)]
class MoveStockCommand extends Command
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
        $products = $this->em->getRepository(Product::class)->findNotOrg($head);
        foreach ($products as $p) {
            $stockRecord = $em->getRepository(Stock::class)->findOneBy(['org' => $p->getOrg(), 'product' => $p]);
            if (is_null($stockRecord)) {
                $stockRecord = new Stock();
                $stockRecord->setStock(0);
                $stockRecord->setOrg($p->getOrg());
                $stockRecord->setProduct($p);
                $em->persist($stockRecord);
            }
            $stockRecord->setStock($p->getStock() + $stockRecord->getStock());
            $this->em->remove($p);
        }
        $this->em->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
