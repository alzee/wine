<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Batch;
use App\Entity\Box;
use App\Entity\Bottle;
use App\Service\Sn;
use App\Service\Enc;
use App\Service\Qr;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[AsEntityListener(event: Events::prePersist, entity: Batch::class)]
class BatchNew extends AbstractController
{
    private $qrdir;
    public function __construct($qrdir)
    {
        $this->qrdir = $qrdir;
    }

    public function prePersist(Batch $batch, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $snStart = $batch->getSnStart();
        $snEnd = $batch->getSnEnd();
        $qty = $batch->getQty();
        $type = $batch->getType();
        $enc = new Enc();
        
        // Batch properties start
        if ($type === 0) {
            $lastBox = $em->getRepository(Box::class)->findLast();
            if (is_null($lastBox)) {
                $start = 1;
            } else {
                $start = $lastBox->getId() + 1;
            }
            $batch->setStart($start);
            $batch->setSnStart(Sn::toSn($start));
            $batch->setSnEnd(Sn::toSn($start + $qty - 1));
        } 
        
        if ($type > 0) { 
            $start = Sn::toId($snStart);
            $batch->setStart($start);
            if (is_null($qty)) {
                $qty = Sn::toId($snEnd) - $start + 1;
                $batch->setQty($qty);
            }
            if (is_null($snEnd)) {
                $snEnd = Sn::toSn($start + $qty - 1);
                $batch->setSnEnd($snEnd);
            }
            // if both snEnd and qty are given, use snEnd
            if ($qty !== Sn::toId($snEnd) - $start + 1) {
                $qty = Sn::toId($snEnd) - $start + 1;
            }
        }
        // Batch properties end
        
        // Create boxes
        if ($type === 0) {
            // $product = $batch->getProduct();
            for ($i = 0; $i < $qty; $i++) {
                $box = new Box;
                $boxSn = Sn::toSn($start + $i);
                $box->setSn($boxSn);
                $box->setCipher($enc->enc($boxSn));
                $box->setBatch($batch);
                $box->setBid($start + $i);
                // $box->setProduct($product);
                $em->persist($box);
                
                // Create bottles;
                for ($j = 1; $j <= $batch->getBottleQty(); $j++) {
                    $bottleSn = $boxSn . '.' . $j;
                    $bottle = new Bottle;
                    $bottle->setBid($j);
                    $bottle->setSn($bottleSn);
                    $bottle->setCipher($enc->enc($bottleSn));
                    $bottle->setBox($box);
                    $em->persist($bottle);
                }
            }
        }
        
        // Download QRs
        if ($type === 2) {
            chdir($this->qrdir);

            $zip = new \ZipArchive();
            $filename = "{$snStart}-{$snEnd}.zip";

            if ($zip->open($filename, \ZipArchive::CREATE) !== TRUE) {
                // exit("cannot open <$filename>\n");
            }

            $boxes = $em->getRepository(Box::class)->findBetween($start, $start + $qty - 1);
            if (! is_null($boxes)) {
                for ($i = $start; $i < $start + $qty; $i++) {
                    if (file_exists(Sn::toSn($i) . '.png')) {
                        $sn = Sn::toSn($i);
                        $zip->addFile("{$sn}.png");
                    }
                }

                // foreach ($boxes as $box) {
                //     $zip->addFile("{$box->getSn()}.png");
                // }
            }
            $zip->close();

            if (file_exists($filename)) {
                if ($sn !== $snEnd) {
                    $newfilename = "{$snStart}-{$sn}.zip";
                    rename($filename, $newfilename);
                    $filename = $newfilename;
                }

                $response =  new BinaryFileResponse($filename);
                $response->headers->set('Content-Type', 'application/zip');
                $response->headers->set('Content-Disposition', "attachment;filename=\"{$filename}\"");
                $response->headers->set('Cache-Control','max-age=0');
                $response->send();

                unlink($filename);
            }
        }
        
        // Download Strings
        if ($type === 3) {
            $url = $_ENV["WXQR_URL"];
            $filename = "{$snStart}-{$snEnd}.xlsx";
            $boxes = $em->getRepository(Box::class)->findBetween($start, $start + $qty - 1);
            if (! is_null($boxes)) {
                $rows = [];
                foreach ($boxes as $box) {
                    foreach ($box->getBottles() as $bottle) {
                        $sn = $bottle->getSn();
                        $enc = explode('.', $bottle->getCipher())[0];
                        $row = [];
                        $row['sn'] = $bottle->getSn();
                        $row['url'] = "{$url}?t=1&s={$sn}&e={$enc}";
                        $rows[] = $row;
                    }
                    $row = [];
                    $sn = $box->getSn();
                    $enc = explode('.', $box->getCipher())[0];
                    $row['sn'] = $sn;
                    $row['url'] = "{$url}?t=0&s={$sn}&e={$enc}";
                    $rows[] = $row;
                }
            }
            
            if ($sn !== $snEnd) {
                $filename = "{$snStart}-{$sn}.xlsx";
            }
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->fromArray($rows, null);

            $writer = new Xlsx($spreadsheet);
            
            $response =  new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                }
            );
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', "attachment;filename=\"{$filename}\"");
            $response->headers->set('Cache-Control','max-age=0');
            $response->send();
        }
    }
}
