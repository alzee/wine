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
use App\Entity\OrderItems;
use App\Entity\ReturnItems;
use App\Entity\Retail;
use App\Entity\RetailReturn;
use App\Entity\Org;

#[AsCommand(
    name: 'app:moveStock',
    description: 'Move stock column data in table Product to table Stock',
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

        // orderItems
        $orderItems = $this->em->getRepository(OrderItems::class)->findAll();
        foreach ($orderItems as $item) {
            $sn = $item->getProduct()->getSn();
            $product = $this->em->getRepository(Product::class)->findOneBy(['sn' => $sn , 'org' => $head]);
            $item->setProduct($product);
        }

        // returnItems
        $returnItems = $this->em->getRepository(ReturnItems::class)->findAll();
        foreach ($returnItems as $item) {
            $sn = $item->getProduct()->getSn();
            $product = $this->em->getRepository(Product::class)->findOneBy(['sn' => $sn , 'org' => $head]);
            $item->setProduct($product);
        }

        // retail
        $retails = $this->em->getRepository(Retail::class)->findAll();
        foreach ($retails as $item) {
            $sn = $item->getProduct()->getSn();
            $product = $this->em->getRepository(Product::class)->findOneBy(['sn' => $sn , 'org' => $head]);
            $item->setProduct($product);
        }

        // retailReturn
        $retailReturn = $this->em->getRepository(RetailReturn::class)->findAll();
        foreach ($retailReturn as $item) {
            $sn = $item->getProduct()->getSn();
            $product = $this->em->getRepository(Product::class)->findOneBy(['sn' => $sn , 'org' => $head]);
            $item->setProduct($product);
        }

        // product
        $products = $this->em->getRepository(Product::class)->findAll();
        foreach ($products as $p) {
            if ($p->getOrg() != $head) {
                $product = $p;
            } else {
                $product = $this->em->getRepository(Product::class)->findOneBy(['sn' => $p->getSn() , 'org' => $head]);
            }
            $stockRecord = $this->em->getRepository(Stock::class)->findOneBy(['org' => $p->getOrg(), 'product' => $product]);
            if (is_null($stockRecord)) {
                $stockRecord = new Stock();
                $stockRecord->setStock(0);
                $stockRecord->setOrg($p->getOrg());
                $stockRecord->setProduct($product);
                $this->em->persist($stockRecord);
            }
            $stockRecord->setStock($p->getStock() + $stockRecord->getStock());

            if ($p->getOrg() != $head) {
                $this->em->remove($p);
            }
        }
        $this->em->flush();

        $io->success('Done.');

        return Command::SUCCESS;
    }
}
