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
use App\Entity\User;
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
        $target_width = 600;
        $target_height = 450;
        $target_quality = 75;
        $thumbnail_width = 200;

        $object = $event->getObject();
        // $mapping = $event->getMapping();

        if ($object instanceof Withdraw) {
            $target_width = 900;
            $target_quality = 85;
        }

        // Uploaded by API
        if ($object instanceof MediaObject) {
            $file = $object->file;
            $type = $object->getType();
            if (is_null($type)) {
                $type = 9;
            }
            $dir = match ($type) {
                0 => 'org',
                1 => 'product',
                2 => 'node',
                3 => 'node/body',
                4 => 'product/body',
                5 => 'widthdraw',
                6 => 'avatar',
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
        if ($object instanceof Org || $object instanceof Node || ($object instanceof MediaObject && $type < 3)) {
            // Only crop if is not featured node
            if (! ($object instanceof Node && in_array(1, $object->getTags()))) {
                $new_height = $target_width / $info[0] * $info[1];
                // Only crop if greater than $target_height
                if ($new_height > $target_height) {
                    $offset_y = ($new_height - $target_height) / 2;
                    $new_file = imagecrop($new_file, ['x' => 0, 'y' => $offset_y, 'width' => $target_width, 'height' => $target_height]);
                }
            }
            // save thumbnail
            $thumbnail_path = $file->getPath() . '/thumbnail/' . preg_replace('/.png/i', '.jpg', $file->getFilename());
            imagejpeg(imagescale($new_file, $thumbnail_width), $thumbnail_path, $target_quality);

            // save image
            imagejpeg($new_file, preg_replace('/.png/i', '.jpg', $file_path), $target_quality);

            if ($info['mime'] != 'image/jpeg') {
                unlink($file_path);
                if (! $object instanceof MediaObject) {
                    $object->setImg(preg_replace('/.png/i', '.jpg', $object->getImg()));
                }
            }
        }

        if ($object instanceof MediaObject) {
            if ($type < 3) {
                symlink('../../../media/thumbnail/' . $file->getFilename(), $file->getPath() . '/../img/' . $dir . '/thumbnail/' . $file->getFilename());
                symlink('../../media/' . $file->getFilename(), $file->getPath() . '/../img/' . $dir . '/' . $file->getFilename());

                $class = match ($type) {
                    0 => Org::class,
                    1 => Product::class,
                    2 => Node::class,
                };
                $entity = $this->em->getRepository($class)->find($object->getEntityId());
                $entity->setImg(preg_replace('/.png/i', '.jpg', $file->getFilename()));
                $this->em->flush();
            }
            if ($type === 6) {
                symlink('../../media/' . $file->getFilename(), $file->getPath() . '/../img/' . $dir . '/' . $file->getFilename());
                $entity = $this->em->getRepository(User::class)->find($object->getEntityId());
                $entity->setAvatar(preg_replace('/.png/i', '.jpg', $file->getFilename()));
                $this->em->flush();
            }
        }
    }
}
