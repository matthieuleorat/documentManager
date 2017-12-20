<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 18/12/17
 * Time: 11:53
 */

namespace App\Action\Document;

use App\DocumentEvents;
use App\Entity\Document;
use App\Event\DocumentDownloadEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class DocumentDownload
{
    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    /**
     * DocumentDownload constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Document $data
     *
     * @Route(
     *     name="document_download",
     *     path="/api/documents/download/{id}",
     *     defaults={"_api_resource_class"=Document::class, "_api_item_operation_name"="download"}
     * )
     * @Method("GET")
     *
     * @return BinaryFileResponse
     */
    public function __invoke(Document $data)
    {
        // Prepare response
        $response = new BinaryFileResponse($data->getFile());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $data->getName().'.'.$data->getFile()->getExtension());

        // Dispatch Download Event
        $event = new DocumentDownloadEvent($data);
        $this->eventDispatcher->dispatch(DocumentEvents::DOCUMENT_DOWNLOAD, $event);

        return $response;
    }
}
