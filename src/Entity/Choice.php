<?php

namespace App\Entity;

class Choice
{
    public const ORDER_STATUSES = ['Pending' => 0, 'Cancelled' => 4, 'Success' => 5];
    public const WITHDRAW_STATUSES = ['Pending' => 0, 'Rejected' => 4, 'Success' => 5];
    public const ORG_TYPES = [
        'Head' => 0,
        'Agency' => 1,
        'Store' => 2,
        'Restaurant' => 3,
        'Consumer' => 4
    ];
    public const VOUCHER_TYPES = [
        '代理商-请货' => 0,
        '门店-请货' => 1,
        '总公司-代理商退货' => 2,
        '代理商-门店退货' => 3,
        '总公司-代理商提现' => 4,
        '代理商-门店提现' => 5,
        '餐厅-顾客消费' => 6,
        '顾客-门店购物' => 7,
        '总公司-代理商请货' => 10,
        '代理商-门店请货' => 11,
        '代理商-退货' => 12,
        '门店-退货' => 13,
        '代理商-提现' => 14,
        '门店-提现' => 15,
        '顾客-餐厅消费' => 16,
        '门店-销售' => 17,
        '内部调控' => 30,
    ];
}
