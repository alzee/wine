<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Service;

use App\Service\Sn;
use App\Entity\Box;

class Qr
{
    public function __construct()
    {
        chdir('qr/');
    }
    
    public function pack(Box $box)
    {
        $boxSn = $box->getSn();
        $boxEnc = explode('.', $box->getCipher())[0];
        $this->gen($boxSn, $boxEnc);
        
        // https://stackoverflow.com/a/39504523/7714132
        // system("convert -size 2000x2000 xc:white bg.png");
        system("composite {$boxSn}.png bg.png {$boxSn}.png");
        
        $bottles = $box->getBottles();
        foreach ($bottles as $bottle) {
            $sn = $bottle->getSn();
            $enc = explode('.', $bottle->getCipher())[0];
            $this->gen($sn, $enc);
            $width = 645;
            $height = 739;
            $ratio = 0.5;
            $col = 3;
            $reszied_w = $width * $ratio;
            $reszied_h = $height * $ratio;
            
            $bid = $bottle->getBid();
            if ($bid % $col === 0) {
                $current_col = 3;
            } else {
                $current_col = $bid % $col;
            }
            $offset_x = $width + $reszied_w * ($current_col - 1);
            $offset_y = $reszied_h * ceil($bid / $col - 1);
            
            system("composite -geometry {$reszied_w}x{$reszied_h}+{$offset_x}+{$offset_y} {$sn}.png {$boxSn}.png {$boxSn}.png");
            system("rm {$sn}.png");
        }
    }
    
    public function gen($sn, $enc) {
        $url = "https://jiu.itove.com/qr/draw";
        $text = "{$url}?s={$sn}?e={$enc}";
        // -s 15 witth 645px;
        system("qrencode -t png -s 15 -m 5 {$text} -o {$sn}.png", $ret);
        system("convert {$sn}.png -pointsize 72 label:{$sn}  -gravity Center -append {$sn}.png");
    }
}

