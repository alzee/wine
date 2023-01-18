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
use Doctrine\ORM\EntityManagerInterface;

class Upload
{
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onVichUploaderPostUpload(Event $event): void
    {
        $target_width = 400;
        $target_height = 200;
        $target_quality = 75;
        $thumbnail_width = 100;

        $object = $event->getObject();
        // $mapping = $event->getMapping();

        if ($object instanceof Withdraw) {
            $target_width = 800;
            $target_quality = 85;
        }

        if ($object instanceof MediaObject) {
            $file = $object->file;
            $type = $object->getType();
            if (is_null($type)) {
                $type = 9;
            }
            if ($type >= 3) {
                $target_width = 600;
            }
            $dir = match ($type) {
                0 => 'org',
                1 => 'product',
                2 => 'node',
                3 => 'node/body',
                4 => 'product/body',
                5 => 'widthdraw',
                9 => 'media',
            };
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
        if ($object instanceof Org || $object instanceof Product || $object instanceof Node || ($object instanceof MediaObject && $type < 3)) {
            $new_height = $target_width / $info[0] * $info[1];
            // Only crop if greater than $target_height
            if ($new_height > $target_height) {
                $offset_y = ($new_height - $target_height) / 2;
                $new_file = imagecrop($new_file, ['x' => 0, 'y' => $offset_y, 'width' => $target_width, 'height' => $target_height]);
            }
            // save thumbnail
            $thumbnail_path = $file->getPath() . '/thumbnail/' . preg_replace('/.png/i', '.jpg', $file->getFilename());
            imagejpeg(imagescale($new_file, $thumbnail_width), $thumbnail_path, 60);
        }

        // save image
        imagejpeg($new_file, preg_replace('/.png/i', '.jpg', $file_path), $target_quality);

        if ($info['mime'] != 'image/jpeg') {
            unlink($file_path);
            $object->setImg(preg_replace('/.png/i', '.jpg', $object->getImg()));
        }

        if ($object instanceof MediaObject) {
            if ($type < 3) {
                rename($thumbnail_path, $file->getPath() . '/../img/' . $dir . '/thumbnail/' . $file->getFilename());
                rename($file_path, $file->getPath() . '/../img/' . $dir . '/' . $file->getFilename());

                $class = match ($type) {
                    0 => Org::class,
                    1 => Product::class,
                    2 => Node::class,
                };
                $entity = $this->em->getRepository($class)->find($object->getEntityId());
                $entity->setImg($file->getFilename());
                $this->em->flush();
            }
        }
    }
}
