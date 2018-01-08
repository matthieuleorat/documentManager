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
    private $user;

    /**
     * DocumentSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger, TokenStorageInterface $tokenStorage)
    {
        $this->logger = $logger;
        $this->user = $tokenStorage->getToken()->getUser();
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
        $this->logger->info('download', ['document' => $document->getId(), 'user' => $this->user->getId()]);
    }
}
