<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 16:47
 */

namespace App\Controller;

use App\Entity\Tag;

class TagAdminController extends AdminController
{
    /**
     * Edit a Tag
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        /** @var Tag $entity */
        $entity = $easyadmin['item'];

        $this->denyAccessUnlessGranted('edit', $entity);

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

        /** @var Tag $entity */
        $entity = $easyadmin['item'];

        $this->denyAccessUnlessGranted('show', $entity);

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

        /** @var Tag $entity */
        $entity = $easyadmin['item'];

        $this->denyAccessUnlessGranted('delete', $entity);

        return parent::deleteAction();
    }
}
