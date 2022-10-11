<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setSpec('spec'.$i);
            $product->setSn('sn'.$i);
            $product->setVoucher(500);
            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }
        $manager->persist($product);

        $manager->flush();
    }
}
