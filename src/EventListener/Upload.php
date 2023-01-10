<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Entity\Org;
use Vich\UploaderBundle\Event\Event;

class Upload extends AbstractController
{
    public function onVichUploaderPostUpload(Event $event): void
    {
        $object = $event->getObject();
        // $mapping = $event->getMapping();
        $file = $object->getImageFile();
        $file_path = $file->getPathname();
        $new_file = match (getimagesize($file_path)['mime']) {
        'image/jpeg' => imagecreatefromjpeg($file_path),
        'image/png' => imagecreatefrompng($file_path),
        'image/gif' => imagecreatefromgif($file_path),
        };
        imagejpeg(imagescale($new_file, 200), $file->getPath() . '/thumbnail/' . preg_replace('/.png/i', '.jpg', $file->getFilename()), 60);
        imagejpeg(imagescale($new_file, 400), preg_replace('/.png/i', '.jpg', $file_path), 75);
    }
}
