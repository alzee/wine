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
        $object = $event->getObject();
        // $mapping = $event->getMapping();
        $file = $object->getImageFile();
        $file_path = $file->getPathname();
        $info = getimagesize($file_path);
        $new_file = match ($info['mime']) {
        'image/jpeg' => imagecreatefromjpeg($file_path),
        'image/png' => imagecreatefrompng($file_path),
        'image/gif' => imagecreatefromgif($file_path),
        };

        imagejpeg(imagescale($new_file, 200), $file->getPath() . '/thumbnail/' . preg_replace('/.png/i', '.jpg', $file->getFilename()), 60);
        imagejpeg(imagescale($new_file, 400), preg_replace('/.png/i', '.jpg', $file_path), 75);

        if ($info['mime'] != 'image/jpeg') {
            unlink($file_path);
            $object->setImg(preg_replace('/.png/i', '.jpg', $object->getImg()));
        }
        

    }
}
