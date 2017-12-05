<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 16:47
 */

namespace App\Controller;

use App\Entity\Document;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DocumentAdminController extends AdminController
{
    public function downloadDocumentAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        /** @var Document $entity */
        $entity = $easyadmin['item'];

        return $this->file($entity->getFile(), $entity->getName());
    }

    public function createDocumentEntityFormBuilder($entity, $view)
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
                ->setParameter('user', 1);
        };

        // Reset choice_list and choice_loader
        unset($tagsOptions['choice_list'], $tagsOptions['choice_loader']);

        // Redefined form children tags
        $formBuilder->add('tags', EntityType::class, $tagsOptions);

        return $formBuilder;
    }
}
