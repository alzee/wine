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

class WxPay
{
    private $httpClient;
    private $wx;

    public function __construct(HttpClientInterface $client, Wx $wx)
    {
        $this->httpClient = $client;
        $this->wx = $wx;
    }

    /**
     * @param array $batch  Batch info ['id', 'name', 'note', 'amount', 'scene']
     * @param array $list   List of transfer [['out_detail_no', 'transfer_amount', 'transfer_remark', 'openid', 'user_name', 'user_id_card'], ...]
     *
     * @return
     */

    public function toBalanceBatch(array $batch, array $list)
    {
        $url = 'https://api.mch.weixin.qq.com/v3/transfer/batches';
        $auth = '';
        $headers[] = "Authorization: {$auth}";
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept:application/json';
        $data = [
            'appid' => $this->wx->getAppid(),
            'out_batch_no' => $batch['id'],
            'batch_name' => $batch['name'],
            'batch_remark' => $batch['note'],
            'total_amount' => $batch['amount'],
            'total_num' => count($list),
            'transfer_detail_list' => $list,
            'transfer_scene_id' =>  isset($batch['scene']) ? $batch['scene'] : ''
        ];

        /**
         * @resp { "out_batch_no" : "plfk2020042013", "batch_id" : "1030000071100999991182020050700019480001", "create_time" : "2015-05-20T13:29:35.120+08:00" }
         */
        $content = $this->httpClient->request('POST', $url, ['headers' => $headers, 'body' => json_encode($data)])->toArray();
        // dump($content);
    }

    public function toBank()
    {
    }
}
