<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Service;

use App\Service\Sn;


class Qr
{
    public function __construct()
    {
    }

    public function gen($snStart, $qty)
    {
        $start = Sn::toId($snStart);
    }
}

