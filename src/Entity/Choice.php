<?php

namespace App\Entity;

class Choice
{
    public const REWARD_TYPES= [
        'refAgency' => 0,
        'refVariantHead' => 1,
        'refVariantAgency' => 2,
        'refStore' => 3,
        'refVariantStore' => 4,
        'refConsumer' => 5,
    ];
    public const SHARE_TYPES= [
        'variantStoreShare' => 0,
        'variantAgencyShare' => 1,
        'variantHeadShare' => 2,
    ];
    public const REWARD_SHARE_STATUSES= [
        'lock' => 0,
        'withdrawable' => 1,
        'withdrawDone' => 2,
        'returned' => 3,
    ];
    public const MEDIA_TYPESS = [
        'org' => 0,
        'product' => 1,
        'node' => 2,
        'node_body' => 3,
        'product_body' => 4,
        'widthdraw' => 5
    ];
    public const ORDER_STATUSES = ['Pending' => 0, 'Cancelled' => 4, 'Success' => 5];
    public const WITHDRAW_STATUSES = ['Pending' => 0, 'Approved' => 3 , 'Rejected' => 4, 'Paid' => 5];
    public const ORG_TYPES = [
        'Head' => 0,
        'Agency' => 1,
        'Store' => 2,
        'Restaurant' => 3,
        'Consumer' => 4,
        'VariantHead' => 10,
        'VariantAgency' => 11,
        'VariantStore' => 12,
    ];
    public const REG_TYPES = [
        'Store' => 0,
        'Agency' => 1,
        'VariantHead' => 2,
        'VariantAgency' => 3,
        'VariantStore' => 4,
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
}
