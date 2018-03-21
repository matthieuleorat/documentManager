<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 20/03/18
 * Time: 13:50
 */

namespace App\Controller\EasyAdmin;

use App\Controller\AdminController;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FolderController extends AdminController
{
    protected function createFolderEntityFormBuilder($entity, $view)
    {
        /** @var User $user */
        $user = $this->getUser();

        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        // Get tags options
        $documentsOptions = $formBuilder->get('documents')->getOptions();

        // Add the correct query to filter tags by user
        $documentsOptions['query_builder'] = function(EntityRepository $er) use ($user) {
            return $er->createQueryBuilder('d')
                ->where('d.user = :user')
                ->setParameter('user', $user);
        };

        // Reset choice_list and choice_loader
        unset($documentsOptions['choice_list'], $documentsOptions['choice_loader']);

        // Redefined form children tags
        $formBuilder->add('documents', EntityType::class, $documentsOptions);

        return $formBuilder;
    }
}