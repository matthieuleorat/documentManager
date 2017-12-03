<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/11/17
 * Time: 10:13
 */

namespace App\Util;


use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Mailer
{

    private $router;

    /** @var \Twig_Environment  */
    private $twig;

    /** @var \Swift_Mailer  */
    private $swift;

    public function __construct(RouterInterface $router, \Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->router = $router;
        $this->twig = $twig;
        $this->swift = $mailer;
    }

    public function sendResetPasswordEmail(User $user)
    {
        $url = $this->router->generate('reset_email', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $message = (new \Swift_Message('Réinitialisation de votre mot de passe'))
            ->setFrom('mama003@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'Security/emails/reset-password.html.twig',[
                        'user' => $user,
                        'url' => $url,
                    ]
                ),
                'text/html'
            );

        $this->swift->send($message);
    }
}