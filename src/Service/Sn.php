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
    public static $left_start = 'A000';
    public static $n = 4;
    public static $right_range = 10 ** 4;

    public static function toSn(int $id)
    {
        // https://stackoverflow.com/a/12001085/7714132
        // box sn 8 bits
        // left 4 bits base36 but started from A000, right 4 bits base10 for readability
        // 36**8 - 10**8 - 26**4 = 2,821,009,450,480
        $int_quotient = intdiv($id, Self::$right_range);
        if ($int_quotient > 0) {
            $id = $id % Self::$right_range;
        }
        $left = base_convert(base_convert(Self::$left_start, 36, 10) + $int_quotient, 10, 36);
        $left = strtoupper($left);
        return $left . str_pad($id, Self::$n, 0, STR_PAD_LEFT);
    }

    public static function toId(string $sn)
    {
        $left = substr($sn, 0, Self::$n);
        $right = substr($sn, Self::$n, Self::$n);
        
        $base10_of_left = base_convert($left, 36, 10);
        $base10_of_left_start = base_convert(Self::$left_start, 36, 10);
        $i = $base10_of_left - $base10_of_left_start;

        if ($i > 0) {
            $right += $i * Self::$right_range;
        }

        return $right;
    }
}
