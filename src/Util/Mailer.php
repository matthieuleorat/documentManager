<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/11/17
 * Time: 10:13
 */

namespace App\Util;


use App\Entity\Document;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Mailer
{
    /** @var RouterInterface */
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
                    'Security/emails/reset-password.html.twig', [
                        'user' => $user,
                        'url' => $url,
                    ]
                ),
                'text/html'
            );

        $this->swift->send($message);
    }

    /**
     * @param string $subject
     * @param string $from
     * @param array|string $to
     * @param string $template
     * @param array $templateParams
     * @param array|null $attachments
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendEmail(string $subject, string $from, $to, string $template, array $templateParams, ?array $attachments = null)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $this->twig->render(
                    $template, $templateParams
                ),
                'text/html'
            );

        if (null !== $attachments) {
            foreach ($attachments as $attachment) {
                if (is_array($attachment)) {
                    $file = $attachment[0];
                    $filename = $attachment[1];
                    $message->attach(
                        \Swift_Attachment::fromPath($file)->setFilename($filename)
                    );
                } else {
                    $message->attach(
                        \Swift_Attachment::fromPath($attachment)
                    );
                }

            }
        }

        $this->swift->send($message);
    }
}
