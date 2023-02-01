<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Service;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Service\Wx;

class Poster
{
    private $httpClient;
    private $wx;
    private $imgdir;

    public function __construct(HttpClientInterface $client, Wx $wx, $imgdir)
    {
        $this->httpClient = $client;
        $this->wx = $wx;
        $this->imgdir = $imgdir;
    }

    public function generate(int $cid)
    {
        $dir = $this->imgdir . '/poster/';
        $access_token = $this->wx->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$access_token}";
        $data = [
            'page' => 'pages/me/index',
            'scene' => $cid,
            'env_version' => 'trial',
            // 'width' => 280 // Min 280px
        ];
        $response = $this->httpClient->request('POST', $url, ['json' => $data]);
        $file = $dir . $cid . '.jpg';
        $fileHandler = fopen($file, 'w');
        foreach ($this->httpClient->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        $poster = new \Imagick($dir . 'poster.jpg');
        $qr = new \Imagick($file);
        $qr->resizeimage(200, 200, \Imagick::FILTER_UNDEFINED, 1);
        $poster->compositeImage($qr, \Imagick::COMPOSITE_ATOP, 200, 720);
        $poster->writeImage($file);
    }
}
