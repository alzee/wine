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

#[AsCommand(
    name: 'wxqr',
    description: 'Manually generate WX QR for consumer',
)]
class WxqrCommand extends Command
{
    public function __construct(WX $wx, HttpClientInterface $client)
    {
        $this->httpClient = $client;
        $this->wx = $wx;
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

        if ($cid) {
            // $io->note(sprintf('You passed an argument: %s', $cid));
        }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $access_token = $this->wx->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=${access_token}";
        $data = [
            'page' => 'pages/index/index',
            'scene' => "cid=${cid}",
            'env_version' => 'trial'
        ];
        $response = $this->httpClient->request('POST', $url, ['json' => $data]);
        $file = "public/img/poster/${cid}.jpg";
        $fileHandler = fopen($file, 'w');
        foreach ($this->httpClient->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
