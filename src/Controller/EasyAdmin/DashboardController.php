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
    public function dashboard(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();

        $form = $this->createForm(SearchTagsType::class, null);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $selectedTags = $form->get('tags')->getData();

            $documents = $em->getRepository(Document::class)->searchByTags($selectedTags);

            return $this->render('EasyAdmin\Dashboard\dashboard.html.twig', [
                'form' => $form->createView(),
                'tags' => $tags,
                'documents' => $documents,
            ]);

            return $this->render('EasyAdmin\fragment\tagselection.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $documents = $em->getRepository(Document::class)->searchByTags();

        return $this->render('EasyAdmin\Dashboard\dashboard.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags,
            'documents' => $documents,
        ]);
    }
}
