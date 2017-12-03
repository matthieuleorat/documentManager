<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 14:41
 */

namespace App\Listener\Doctrine;

use App\Entity\Document;
use App\Manager\DocumentManager;
use App\Util\PdfThumbnailGenerator;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\EventSubscriber;

class DoctrineDocumentSubscriber implements EventSubscriber
{
    /** @var  string */
    private $project_dir;

    /** @var DocumentManager  */
    private $documentManager;

    public function __construct($project_dir, DocumentManager $documentManager)
    {
        $this->project_dir = $project_dir;
        $this->documentManager = $documentManager;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'prePersist',
            'preUpdate',
            'preRemove'
        );
    }

    /**
     * On prepersist, upload the document file
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var Document $document */
        if (false === ($document = $this->isDocument($args))) {
            return;
        }

        // Upload Document File
        $this->documentManager->uploadDocumentFile($document);
    }

    /**
     * On preUpdate, delete precedent file
     * then updload new file
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        /** @var Document $document */
        if (false === ($document = $this->isDocument($args))) {
            return;
        }

        // Delete precedent File
        $precedentFile = $args->getEntityChangeSet()['file'][0];
        $this->documentManager->deletePrecedentFile($document, $precedentFile);

        // Upload Document File
        $this->documentManager->uploadDocumentFile($document);
    }

    /**
     * On preRemove, delete document file from server
     *
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        /** @var Document $document */
        if (false === ($document = $this->isDocument($args))) {
            return;
        }

        // Delete Document
        $this->documentManager->deleteDocumentFile($document);
    }

    /**
     * On postLoad, load an File object in the file's document attribute
     *
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        /** @var Document $document */
        if (false === ($document = $this->isDocument($args))) {
            return;
        }

        $this->documentManager->handleFile($document);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return bool|Document
     */
    private function isDocument(LifecycleEventArgs $args)
    {
        /** @var Document|bool $document */
        if (false === ($document = $args->getObject()) instanceof Document) {
            return false;
        }

        return $document;
    }
}