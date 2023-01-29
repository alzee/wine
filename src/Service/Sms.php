<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Service;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Sms
{
    private $a;
    private $b;
    private $c;
    
    public function __construct()
    {
    }

    public function send($phone, $type = 'verify')
    {
        $accessKeyId = $_ENV['accessKeyId'];
        $accessKeySecret = $_ENV['accessKeySecret'];
        $signName = $_ENV['SIGN_NAME'];
        switch($type){
            case 'verify':
                $templateCode = 'SMS_268695017';
                break;
            case 'login':
                $templateCode = 'SMS_211140348';
                break;
            case 'alert':
                $templateCode = 'SMS_211140347';
                break;
            case 'regsiter':
                $templateCode = 'SMS_211140346';
                break;
            case 'passwd':
                $templateCode = 'SMS_211140345';
                break;
            case 'usermod':
                $templateCode = 'SMS_211140344';
                break;
            case 'reg_notice':
                // 用户${name}提交了一条合作报备，类型${type}，单位名称${orgName}，联系人${contact}，联系电话${phone}。
                $templateCode = 'SMS_268530712';
                break;
            default:
                $templateCode = 'SMS_211140348';
        }

        $code = mt_rand(100000, 999999);
        $config = new Config([
            "accessKeyId" => $accessKeyId,
            "accessKeySecret" => $accessKeySecret 
        ]);
        $client = new Dysmsapi($config);
        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => $phone,
            "signName" => $signName,
            "templateCode" => $templateCode,
            "templateParam" => "{\"code\":\"$code\"}"
        ]);
        $client->sendSms($sendSmsRequest);

        $cache = new RedisAdapter(RedisAdapter::createConnection('redis://localhost'));
        // $cache = new FilesystemAdapter();

        $cache->clear($phone);

        $cache->get($phone, function (ItemInterface $item) use ($code){
            $item->expiresAfter(300);
            return $code;
        });
    }
}
