<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\DBAL\Exception\DriverException;
use App\Entity\Consumer;
use App\Service\WX;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConsumerNew extends AbstractController
{
    private $httpClient;
    private $wx;

    public function __construct(WX $wx, HttpClientInterface $client)
    {
        $this->httpClient = $client;
        $this->wx = $wx;
    }

    public function postPersist(Consumer $consumer, LifecycleEventArgs $event): void
    {
        $cid = $consumer->getId();
        $access_token = $this->wx->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=${access_token}";
        $data = [
            'page' => 'pages/index/index',
            'scene' => $cid,
            'env_version' => 'trial',
            // 'width' => 280 // Min 280px
        ];
        $response = $this->httpClient->request('POST', $url, ['json' => $data]);
        $file = "img/poster/${cid}.jpg";
        $fileHandler = fopen($file, 'w');
        foreach ($this->httpClient->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        $poster = new \Imagick('img/poster/poster.jpg');
        $qr = new \Imagick($file);
        $qr->resizeimage(200, 200, \Imagick::FILTER_UNDEFINED, 1);
        $poster->compositeImage($qr, \Imagick::COMPOSITE_ATOP, 200, 720);
        $poster->writeImage($file);
    }
}
