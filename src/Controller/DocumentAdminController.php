<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 16:47
 */

namespace App\Controller;

use App\Entity\Document;

class DocumentAdminController extends AdminController
{
    public function downloadDocumentAction()
    {
        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');

        /** @var Document $entity */
        $entity = $easyadmin['item'];

        return $this->file($entity->getFile(), $entity->getName());
    }
}