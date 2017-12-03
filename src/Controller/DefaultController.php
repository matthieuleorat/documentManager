<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 19/11/17
 * Time: 18:21
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function number(Request $request)
    {


        $em = $this->getDoctrine()->getManager();


        $number = mt_rand(0, 100);

        return $this->render('number.html.twig', array(
            'number' => $number,
        ));
    }

    public function test()
    {
        $number = mt_rand(0, 100);

        return $this->render('number.html.twig', array(
            'number' => $number,
        ));
    }
}