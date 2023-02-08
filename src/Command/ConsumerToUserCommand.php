<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Consumer;
use App\Entity\User;
use App\Entity\Org;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:consumerToUser',
    description: 'Add a short description for your command',
)]
class ConsumerToUserCommand extends Command
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

        $consumers = $this->em->getRepository(Consumer::class)->findAll();
        $consumerOrg = $this->em->getRepository(Org::class)->findOneBy(['type' => 4]);
        $io->note('Creating user from consumer...');
        foreach ($consumers as $c) {
            $u = new User();
            $u->setOrg($consumerOrg);
            $u->setPhone($c->getPhone());
            $u->setOpenid($c->getOpenid());
            $u->setVoucher($c->getVoucher());
            $u->setName($c->getName());
            $u->setAvatar($c->getAvatar());
            $u->setUpdatedAt($c->getUpdatedAt());
            $u->setCreatedAt($c->getCreatedAt());
            $u->setReward($c->getReward());
            $u->setWithdrawable($c->getWithdrawable());
            $u->setWithdrawing($c->getWithdrawing());
            $u->setNick($c->getNick());

            if (! is_null($c->getPhone())) {
                $user = $this->em->getRepository(User::class)->findOneBy(['phone' => $c->getPhone()]);
                if (! is_null($user)) {
                    $user->setPhone(null);
                    $io->warning("User {$user->getUsername()}'s phone have bean clear due to duplicate cumsumer phone");
                    $this->em->flush();
                }
            }
            $io->info($c->getId() .' '. $c->getName() .' '. $c->getOpenid());
            $this->em->persist($u);
        }

        $this->em->flush();

        $io->note('Updating user referrer...');
        foreach ($consumers as $c) {
            if (! is_null($c->getReferrer())) {
                $referrer_in_consumer = $this->em->getRepository(Consumer::class)->find($c->getReferrer());
                $referrer_in_user = $this->em->getRepository(User::class)->findOneBy(['openid' => $referrer_in_consumer->getOpenid()]);
                $u = $this->em->getRepository(User::class)->findOneBy(['openid' => $c->getOpenid()]);
                $u->setReferrer($referrer_in_user);
                $io->info($u->getId() .' '. $u->getName() .' '. $u->getOpenid() .' Referrer: '. $u->getReferrer()->getId() . ' '. $u->getReferrer()->getName());
            }
        }

        $this->em->flush();

        $io->success('Done.');

        return Command::SUCCESS;
    }
}
