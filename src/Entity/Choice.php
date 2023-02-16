<?php

namespace App\Entity;

class Choice
{
    public const BATCH_TYPES = [
        'new' => 0,
        'edit' => 1,
        'qr' => 2
    ];
    
    public const BOTTLE_STATUSES = [
        'for_sale' => 0,
        'sold' => 1,
        'waiter_scanned' => 2
    ];

    public const REWARD_TYPES = [
        'agency' => 0,
        'variant_head' => 1,
        'variant_agency' => 2,
        'store' => 3,
        'variant_store' => 4,
        'restaurant' => 5,
        'customer' => 6,
    ];
    public const SHARE_TYPES = [
        'variant_store' => 0,
        'variant_agency' => 1,
        'variant_head' => 2,
        'return' => 3
    ];
    public const REWARD_SHARE_STATUSES = [
        'lock' => 0,
        'withdrawable' => 1,
        'withdraw_done' => 2,
        'return_lock' => 3,
        'returned' => 4,
    ];
    public const MEDIA_TYPESS = [
        'org' => 0,
        'product' => 1,
        'node' => 2,
        'node_body' => 3,
        'product_body' => 4,
        'widthdraw' => 5,
        'avatar' => 6
    ];
    public const ORDER_STATUSES = ['Pending' => 0, 'Cancelled' => 4, 'Success' => 5];
    public const WITHDRAW_STATUSES = ['Pending' => 0, 'Approved' => 3 , 'Rejected' => 4, 'Paid' => 5];
    public const ORG_TYPES = [
        'head' => 0,
        'agency' => 1,
        'store' => 2,
        'restaurant' => 3,
        'customer' => 4,
        'Variant_head' => 10,
        'Variant_agency' => 11,
        'Variant_store' => 12,
    ];
    public const REG_TYPES = [
        'Store' => 0,
        'Agency' => 1,
        'variant_head' => 2,
        'variant_agency' => 3,
        'variant_store' => 4,
    ];
    public const REG_STATUSES = [
        'pending' => 0,
        'deal' => 1,
    ];
    public const VOUCHER_TYPES = [
        // increase
        '进货' => 0,
        '购酒' => 3,
        '退货接收' => 5,
        '提现兑付' => 10,
        '顾客餐饮消费' => 12,
        '零售退货' => 13,
        // '代理商-进货' => 0,
        // '门店-进货' => 1,
        // '餐厅-进货' => 2,
        // '顾客-门店购酒' => 3,
        // '顾客-餐厅购酒' => 4,
        // '总公司-代理商退货' => 5,
        // '代理商-门店退货' => 6,
        // '代理商-餐厅退货' => 7,
        //'门店-顾客退货' => 8,
        //'餐厅-顾客退货' => 9,
        // '总公司-代理商提现' => 10,
        // '代理商-餐厅提现' => 11,
        // '餐厅-顾客餐饮消费' => 12,

        // decrease
        '发货' => 100,
        '酒零售' => 103,
        '退货发出' => 105,
        '申请提现' => 110,
        '餐饮消费' => 112,
        '酒退货' => 113,
        // '总部-代理商进货' => 100,
        // '代理商-门店进货' => 101,
        // '代理商-餐厅进货' => 102,
        // '门店-顾客购酒' => 103,
        // '餐厅-顾客购酒' => 104,
        // '代理商-退货' => 105,
        // '门店-退货' => 106,
        // '餐厅-退货' => 107,
        // '顾客-退货' => 108,
        // '顾客-退货' => 109,
        // '代理商-提现' => 110,
        // '餐厅-提现' => 111,
        // '顾客-餐饮消费' => 112,
        // system
        '内部调控' => 255,
    ];

    public static function get($taxon)
    {
        $taxon = strtoupper($taxon);
        $constant = constant('Self::' . $taxon);
        return $constant;
    }
}
