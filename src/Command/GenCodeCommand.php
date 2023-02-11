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

#[AsCommand(
    name: 'app:gen-code',
    description: 'Genarate product codes',
)]
class GenCodeCommand extends Command
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

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        $cipher = "aes-128-gcm";
        // $cipher = "aes-128-cbc";
        $code = new Code();
        $this->em->persist($code);
        // $this->em->flush();
        $ciphers = openssl_get_cipher_methods();
        // dump($ciphers);

        $key = '123';
        $plaintext = 'A0000100';
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
        // dump($ivlen);
        // dump(base64_encode($iv));
        // dump($ciphertext);

        $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
        // dump($original_plaintext);

        // $io->info($ciphertext);

        // https://stackoverflow.com/a/12001085/7714132
        $start = 'A0000000';
        $id = 1;
        $start_base10 = base_convert($start, 36, 10);
        $base36 = base_convert($id + $start_base10, 10, 36);
        $base36 = strtoupper($base36);
        dump($base36);
        return Command::SUCCESS;
    }
}
