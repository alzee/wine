<?php

namespace App\Entity;

class Choice
{
    public const ORDER_STATUSES = ['Pending' => 0, 'Cancelled' => 4, 'Success' => 5];
    public const WITHDRAW_STATUSES = ['Pending' => 0, 'Rejected' => 4, 'Success' => 5];
}
