<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 18/12/17
 * Time: 11:53
 */

namespace App\Action\Document;

use App\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class DocumentDownload
{
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
     * @return string|\Symfony\Component\HttpFoundation\File\File
     */
    public function __invoke(Document $data) // API Platform retrieves the PHP entity using the data provider then (for POST and
        // PUT method) deserializes user data in it. Then passes it to the action. Here $data
        // is an instance of Book having the given ID. By convention, the action's parameter
        // must be called $data.
    {
        $response = new BinaryFileResponse($data->getFile());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $data->getName().'.'.$data->getFile()->getExtension());

        return $response;

        //return $data->getFile(); // API Platform will automatically validate, persist (if you use Doctrine) and serialize an entity
        // for you. If you prefer to do it yourself, return an instance of Symfony\Component\HttpFoundation\Response
    }
}
