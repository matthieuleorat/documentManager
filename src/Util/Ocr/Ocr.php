<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 30/03/18
 * Time: 08:38
 */

namespace App\Util\Ocr;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\File\File;
use thiagoalessio\TesseractOCR\TesseractOCR;

class Ocr
{
    public function convertPdfToTiff(string $path)
    {
        try {
            $file = new File($path);
        } catch(FileNotFoundException $exception) {
            die(dump($exception->getMessage()));
        }

        $outputTiffFile = $file->getPath().'/tifffile.tiff';


        $cmd = 'convert -density 300 '.$file->getPathname().' -depth 8 -strip -background white -alpha off '.$outputTiffFile;
        $process = new Process($cmd);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $outputTiffFile;
    }

    public function ExtractTextFromImg(string $path)
    {
        try {
            $file = new File($path);
        } catch(FileNotFoundException $exception) {
            die(dump($exception->getMessage()));
        }

        $content = (new TesseractOCR($file->getPathname()))
            ->lang('fra')
            ->run();

        return $content;
    }
}
