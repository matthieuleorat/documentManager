<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 15:03
 */

namespace App\Manager;

use App\Entity\Document;
use App\Entity\User;
use App\Util\FileManager;
use App\Util\Mailer;
use App\Util\PdfThumbnailGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class DocumentManager
 * @package App\Manager
 */
class DocumentManager
{
    /** @var FileManager  */
    private $fileManager;

    /** @var string  */
    private $document_directory;

    /** @var string  */
    private $project_dir;

    /** @var PdfThumbnailGenerator  */
    private $thumbnailGenerator;

    /** @var string */
    private $url;

    /** @var Mailer */
    private $mailer;

    /**
     * DocumentManager constructor.
     * @param FileManager $fileManager
     * @param PdfThumbnailGenerator $thumbnailGenerator
     * @param $projectDir
     * @param $document_directory
     * @param $app_url
     * @param Mailer $mailer
     */
    public function __construct(
        FileManager $fileManager,
        PdfThumbnailGenerator $thumbnailGenerator,
        $projectDir,
        $document_directory,
        $app_url,
        Mailer $mailer
    )
    {
        $this->thumbnailGenerator = $thumbnailGenerator;
        $this->fileManager = $fileManager;
        $this->project_dir = $projectDir.'/public';
        $this->document_directory = $document_directory;
        $this->url = $app_url;
        $this->mailer = $mailer;
    }

    /**
     * Upload a document on the server
     * - Generate a unique name
     * - Upload the file
     * - Generate a thumbnail
     *
     * @param Document $document
     */
    public function uploadDocumentFile(Document $document)
    {
        /** @var UploadedFile $file */
        $file = $document->getFile();

        $document->setOriginalFileName($file->getClientOriginalName());

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $document->setFile($fileName);

        $path = $this->getRelativePath($document->getUser());
        $document->setpath($path);

        $this->fileManager->uploadFile($file, $fileName, $this->project_dir.$path);

        $thumbnailName = $this->generatorThumbnailName();
        $document->setThumbnail($path.'/'.$thumbnailName);

        $this->thumbnailGenerator->generateThumbnail($fileName, $this->project_dir.$path.'/', $thumbnailName);
    }

    /**
     * Delete document & thumbnail from server
     *
     * @param Document $document
     */
    public function deleteDocumentFile(Document $document)
    {
        $this->deleteThumbnail($document);

        if ($document->getFile() instanceof File){
            $this->fileManager->deleteFile($document->getFile());
        }

    }

    /**
     * Delete precedent file
     *
     * @param Document $document
     * @param $precedentFile
     */
    public function deletePrecedentFile(Document $document, $precedentFile)
    {
        $filePath = $this->project_dir.$document->getpath().'/'.$precedentFile;

        $this->fileManager->deleteFileByPath($filePath);
    }

    /**
     * If document's file attribute is a string, transform it in a File object
     *
     * @param Document $document
     */
    public function handleFile(Document $document)
    {
        if (true === is_string($document->getFile())) {
            $filePath = $this->project_dir.$document->getpath().'/'.$document->getFile();

            if (false !== file_exists($filePath)) {
                $document->setFile($this->fileManager->createFileFormPath($filePath));
            }
        }
    }

    /**
     * Delete thumbnail from server
     *
     * @param Document $document
     */
    public function deleteThumbnail(Document $document)
    {
        if (null !== $document->getThumbnail()) {
            $thumbnail = $this->project_dir.$document->getThumbnail();
    
            $this->fileManager->deleteFileByPath($thumbnail);
        }
    }

    public function constructFullThumbnailPath(Document $document)
    {
        $thumbnailFullPath = $this->url.$document->getThumbnail();
        $document->setFullThumbnailPath($thumbnailFullPath);
    }

    public function sendDocumentTo(Document $document, $to, $subject, $message)
    {
        $from = $document->getUser()->getEmail();
        $template = 'App/Emails/sendDocumentTo.html.twig';
        $templateParams = ['message' => $message];
        $attachments = [
            [$document->getFile()->getPathname(), $document->getName().'.'.$document->getFile()->getExtension()]
        ];


        $this->mailer->sendEmail($subject, $from, $to, $template, $templateParams, $attachments);

    }

    /**
     * Generate thumbnail name
     *
     * @return string
     */
    private function generatorThumbnailName()
    {
        return 'thumbnail-'.md5(uniqid()).'.jpg';
    }

    /**
     * Generate relative path to store file & thumbnail
     *
     * @param User $user
     * @return string
     */
    private function getRelativePath(User $user)
    {
        $date = new \DateTime();
        $path = $this->document_directory.'/'.$user->getId().'/'.$date->format('Y/m');

        return $path;
    }
}
