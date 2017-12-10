<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 17:05
 */

namespace App\Util;

use Symfony\Component\HttpFoundation\File\File;

class PdfThumbnailGenerator
{
    private $thumbnailSize = 75;

    public function generateThumbnail($fileName, $path, $thumbnailName)
    {
        $file = new File($path.$fileName);

        // If file is not a a Pdf, return
        if (strtolower($file->getExtension()) !== 'pdf') {
            return;
        }

        if (extension_loaded('imagick')) {

            $i = new \Imagick($path.$fileName."[0]");
            //set new format
            $i->setImageFormat('jpg');
            $i->setCompression(\Imagick::COMPRESSION_JPEG);
            $i->setCompressionQuality(100);

            // Get size
            $imageSize = $i->getImageGeometry();

            // Resize picture keep aspect ratio, upscale allowed.
            if ($imageSize['width'] > $imageSize['height']) {
                $i->scaleImage($this->thumbnailSize, 0);
            } else {
                $i->scaleImage(0, $this->thumbnailSize);
            }

            $thumbnail = $path.$thumbnailName;

            $i->writeImages($thumbnail,false);
        }
    }
}
