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

class Wx
{
    private $httpClient;
    private $appid;
    private $secret;

    public function __construct(HttpClientInterface $client)
    {
        $this->httpClient = $client;
        $this->appid = $_ENV['WX_APP_ID'];
        $this->secret = $_ENV['WX_APP_SECRET'];
    }

    public function getAccessToken()
    {
        $cache = new RedisAdapter(RedisAdapter::createConnection('redis://localhost'));
        // $cache = new FilesystemAdapter();

        return $cache->get('WX_ACCESS_TOKEN', function (ItemInterface $item) {
            $item->expiresAfter(7200);
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}";
            $content = $this->httpClient->request('GET', $url)->toArray();
            // dump($content);
            return $content['access_token'];
        });
    }

    public function getOpenid($code)
    {
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->appid}&secret={$this->secret}&js_code=$code&grant_type=authorization_code";
        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept:application/json';
        $content = $this->httpClient->request('GET', $url ,['headers' => $header])->toArray();
        $sessionKey = $content['session_key'];
        $openid = $content['openid'];

        return $openid;
    }
}
