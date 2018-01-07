<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/12/17
 * Time: 16:02
 */

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Api/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }
}
