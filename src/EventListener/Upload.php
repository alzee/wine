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
        $mapping = $event->getMapping();
        $file = $object->getImageFile();
        dump($object);
        dump($mapping);
        dump($file);
    }
}
