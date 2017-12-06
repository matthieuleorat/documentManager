<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/11/17
 * Time: 16:38
 */

namespace App\Controller;

use App\Behavior\UserableInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    /**
     * Edit a Tag
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        $entity = $easyadmin['item'];

        if ($entity instanceof UserableInterface) {
            $this->denyAccessUnlessGranted('edit', $entity);
        }

        return parent::editAction();
    }

    /**
     * Display a Tag
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function showAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        $entity = $easyadmin['item'];

        if ($entity instanceof UserableInterface) {
            $this->denyAccessUnlessGranted('edit', $entity);
        }

        return parent::showAction();
    }

    /**
     * Delete a Tag
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function deleteAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        $entity = $easyadmin['item'];

        if ($entity instanceof UserableInterface) {
            $this->denyAccessUnlessGranted('edit', $entity);
        }

        return parent::deleteAction();
    }


    protected function findAll($entityClass, $page = 1, $maxPerPage = 15, $sortField = null, $sortDirection = null, $dqlFilter = null)
    {
        $dqlFilter = $this->userDqlFilter($entityClass, $dqlFilter);

        return parent::findAll($entityClass, $page, $maxPerPage, $sortField, $sortDirection, $dqlFilter);
    }

    private function userDqlFilter($entityClass, $dqlFilter = null)
    {
        $entityObject = new $entityClass();

        // If object is UserAble, then filter on the user id
        if (true === $entityObject instanceof UserableInterface) {
            $dqlFilterUserPart = "entity.user = ".$this->getUser()->getId();

            return $dqlFilter.(null === $dqlFilter ? $dqlFilterUserPart : " and ".$dqlFilterUserPart);
        }

        return $dqlFilter;
    }
}
