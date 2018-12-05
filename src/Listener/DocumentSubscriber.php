<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/12/17
 * Time: 08:30
 */

namespace App\Listener;

use App\DocumentEvents;
use App\Entity\Document;
use App\Entity\User;
use App\Event\DocumentDownloadEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DocumentSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var User  */
    private $tokenStorage;

    /**
     * DocumentSubscriber constructor.
     * @param LoggerInterface $logger
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(LoggerInterface $logger, TokenStorageInterface $tokenStorage)
    {
        $this->logger = $logger;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            DocumentEvents::DOCUMENT_DOWNLOAD => 'onDocumentDownload'
        );
    }

    /**
     * @param DocumentDownloadEvent $event
     */
    public function onDocumentDownload(DocumentDownloadEvent $event)
    {
        /** @var Document $document */
        $document = $event->getDocument();

        $user = $this->tokenStorage->getToken() === null ? null : $this->tokenStorage->getToken()->getUser();

        $this->logger->info('download', ['document' => $document->getId(), 'user' => $user->getId()]);
    }
}
