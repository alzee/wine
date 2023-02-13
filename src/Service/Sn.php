<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Service;

class Sn
{
    public static function gen(int $id)
    {
        // https://stackoverflow.com/a/12001085/7714132
        // box sn 8 bits
        // left 4 bits base36 but started from A000, right 4 bits base10 for readability
        // 36**8 - 10**8 - 26**4 = 2,821,009,450,480
        $left_start = 'A000';
        $n = 4;
        $right_range = 10 ** $n;
        $int_quotient = intdiv($id, $right_range);
        if ($int_quotient > 0) {
            $id = $id % $right_range;
        }
        $left = base_convert(base_convert($left_start, 36, 10) + $int_quotient, 10, 36);
        $left = strtoupper($left);
        return $left . str_pad($id, $n, 0, STR_PAD_LEFT);
    }
}
