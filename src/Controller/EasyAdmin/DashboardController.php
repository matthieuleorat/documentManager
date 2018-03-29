<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/03/18
 * Time: 14:25
 */

namespace App\Controller\EasyAdmin;

use App\Controller\AdminController;
use App\Entity\Document;
use App\Entity\Tag;
use App\Form\Type\SearchTagsType;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AdminController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard(Request $request)
    {
        $form = $this->createForm(SearchTagsType::class);

        $form->handleRequest($request);

        $selectedTags = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedTags = $form->get('tags')->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository(Document::class)->searchByTags($selectedTags);

        return $this->render('EasyAdmin\Dashboard\dashboard.html.twig', [
            'form' => $form->createView(),
            'documents' => $documents,
        ]);
    }
}
