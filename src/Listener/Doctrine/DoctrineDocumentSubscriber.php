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
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Psr\Log\LoggerInterface;
use Doctrine\Common\EventSubscriber;

class DoctrineDocumentSubscriber implements EventSubscriber
{
    /** @var DocumentManager  */
    private $documentManager;

    /** @var LoggerInterface  */
    private $logger;

    public function __construct(DocumentManager $documentManager, LoggerInterface $logger)
    {
        $this->documentManager = $documentManager;
        $this->logger = $logger;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'prePersist',
            'postPersist',
            'preUpdate',
            'postUpdate',
            'preRemove',
            'postRemove',
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

    public function postPersist(LifecycleEventArgs $args)
    {
        /** @var Document $document */
        $document = $args->getEntity();
        $this->logger->info('create', ['document' => $document->getId(), 'user' => $document->getUser()->getId()]);
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

    public function postUpdate(LifecycleEventArgs $args)
    {
        /** @var Document $document */
        $document = $args->getEntity();
        $this->logger->info('edit', ['document' => $document->getId(), 'user' => $document->getUser()->getId()]);
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

    public function postRemove(LifecycleEventArgs $args)
    {
        /** @var Document $document */
        if (false === ($document = $this->isDocument($args))) {
            return;
        }

        $this->logger->info('remove', ['document' => $document->getOldId(), 'user' => $document->getUser()->getId()]);
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

        // Transform file path in a File object
        $this->documentManager->handleFile($document);

        // Init oldId
        $document->setOldId();
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
