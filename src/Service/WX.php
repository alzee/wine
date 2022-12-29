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

class WX
{
    private $httpClient;

    public function __construct(HttpClientInterface $client)
    {
        $this->httpClient = $client;
    }

    public function getAccessToken()
    {
        $cache = new RedisAdapter(RedisAdapter::createConnection('redis://localhost'));
        // $cache = new FilesystemAdapter();

        return $cache->get('WX_ACCESS_TOKEN', function (ItemInterface $item) {
            $item->expiresAfter(7200);
            $appid = $_ENV['WX_APP_ID'];
            $secret = $_ENV['WX_APP_SECRET'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=${appid}&secret=${secret}";
            $content = $this->httpClient->request('GET', $url)->toArray();
            // dump($content);
            return $content['access_token'];
        });
    }
}
