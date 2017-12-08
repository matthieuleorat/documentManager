<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 16:47
 */

namespace App\Controller;

use App\DocumentEvents;
use App\Entity\Document;
use App\Entity\User;
use App\Event\DocumentDownloadEvent;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventDispatcher;

class DocumentAdminController extends AdminController
{
    /**
     * Return a document
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadDocumentAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        /** @var Document $entity */
        $entity = $easyadmin['item'];

        // Check if user is authirized to downaload this document
        $this->denyAccessUnlessGranted('download', $entity);

        // Dispatch DocumentDownloadEvent
        $event = new DocumentDownloadEvent($entity);
        $this->get('event_dispatcher')->dispatch(DocumentEvents::DOCUMENT_DOWNLOAD, $event);

        // Return file
        return $this->file($entity->getFile(), $entity->getName());
    }

    /**
     * Return a form builder for document creation & edition
     * - Filter tag list by user
     *
     * @param $entity
     * @param $view
     *
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function createDocumentEntityFormBuilder($entity, $view)
    {
        /** @var User $user */
        $user = $this->getUser();

        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        // Get tags options
        $tagsOptions = $formBuilder->get('tags')->getOptions();

        // Add the correct query to filter tags by user
        $tagsOptions['query_builder'] = function (EntityRepository $er) use ($user) {
            return $er->createQueryBuilder('t')
                ->where('t.user = :user')
                ->setParameter('user', $user);
        };

        // Reset choice_list and choice_loader
        unset($tagsOptions['choice_list'], $tagsOptions['choice_loader']);

        // Redefined form children tags
        $formBuilder->add('tags', EntityType::class, $tagsOptions);

        return $formBuilder;
    }
}
