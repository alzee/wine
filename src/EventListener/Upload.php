<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Vich\UploaderBundle\Event\Event;

class Upload
{
    public function onVichUploaderPostUpload(Event $event): void
    {
        $width = 400;
        $height = 200;
        $thumbnail_width = 100;
        $object = $event->getObject();
        // $mapping = $event->getMapping();
        $file = $object->getImageFile();
        $file_path = $file->getPathname();
        $info = getimagesize($file_path);
        $new_file = match ($info['mime']) {
        'image/jpeg' => imagescale(imagecreatefromjpeg($file_path), $width),
        'image/png' => imagescale(imagecreatefrompng($file_path), $width),
        };

        $new_height = $width / $info[0] * $info[1];
        if ($new_height > $height) {
            $offset_y = ($new_height - $height) / 2;
        } else {
            $offset_y = 0;
        }
        // crop height
        $new_file = imagecrop($new_file, ['x' => 0, 'y' => $offset_y, 'width' => $width, 'height' => $height]);

        // save thumbnail
        imagejpeg(imagescale($new_file, $thumbnail_width), $file->getPath() . '/thumbnail/' . preg_replace('/.png/i', '.jpg', $file->getFilename()), 60);

        // save image
        imagejpeg($new_file, preg_replace('/.png/i', '.jpg', $file_path), 75);

        if ($info['mime'] != 'image/jpeg') {
            unlink($file_path);
            $object->setImg(preg_replace('/.png/i', '.jpg', $object->getImg()));
        }
        

    }
}
