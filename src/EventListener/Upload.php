<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Vich\UploaderBundle\Event\Event;
use App\Entity\Org;
use App\Entity\Withdraw;
use App\Entity\Product;
use App\Entity\Node;
use App\Entity\MediaObject;

class Upload
{
    public function onVichUploaderPostUpload(Event $event): void
    {
        $target_width = 400;
        $target_height = 200;
        $target_quality = 75;
        $thumbnail_width = 100;

        $object = $event->getObject();
        // $mapping = $event->getMapping();

        if ($object instanceof Withdraw || $object instanceof MediaObject) {
            $target_width = 800;
            $target_quality = 85;
        }

        if ($object instanceof MediaObject) {
            $file = $object->file;
        } else {
            $file = $object->getImageFile();
        }
        $file_path = $file->getPathname();

        $info = getimagesize($file_path);
        $new_file = match ($info['mime']) {
        'image/jpeg' => imagescale(imagecreatefromjpeg($file_path), $target_width),
        'image/png' => imagescale(imagecreatefrompng($file_path), $target_width),
        };

        // if is org/product/node image, crop height and create thumbnail
        if ($object instanceof Org || $object instanceof Product || $object instanceof Node) {
            $new_height = $target_width / $info[0] * $info[1];
            // Only crop if greater than $target_height
            if ($new_height > $target_height) {
                $offset_y = ($new_height - $target_height) / 2;
                $new_file = imagecrop($new_file, ['x' => 0, 'y' => $offset_y, 'width' => $target_width, 'height' => $target_height]);
            }
            // save thumbnail
            imagejpeg(imagescale($new_file, $thumbnail_width), $file->getPath() . '/thumbnail/' . preg_replace('/.png/i', '.jpg', $file->getFilename()), 60);
        }

        // save image
        imagejpeg($new_file, preg_replace('/.png/i', '.jpg', $file_path), $target_quality);

        if ($info['mime'] != 'image/jpeg') {
            unlink($file_path);
            $object->setImg(preg_replace('/.png/i', '.jpg', $object->getImg()));
        }
    }
}
