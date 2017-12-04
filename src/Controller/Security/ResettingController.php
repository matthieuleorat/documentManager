<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/11/17
 * Time: 07:40
 */

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\Type\Security\ResetPasswordType;
use App\Manager\UserManager;
use App\Util\Mailer;
use App\Util\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResettingController extends Controller
{
    private $ttl = 1114400; // 310 heures

    /**
     * Step 1: Display a form to ask username
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function requestPassword()
    {
        return $this->render('Security/request-password.html.twig');
    }

    /**
     * Step 2: Send a resetting password email to user
     *
     * @param Request $request
     * @param UserManager $userManager
     * @param Mailer $mailer
     * @param TokenGenerator $tokenGenerator
     *
     * @return RedirectResponse
     */
    public function sendEmail(Request $request, UserManager $userManager, Mailer $mailer, TokenGenerator $tokenGenerator)
    {
        $username = $request->request->get('username');

        /** @var User $user */
        $user = $userManager->findUserByUsername($username);

        if (null !== $user && !$user->isPasswordRequestNonExpired($this->ttl)) {

            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }

            // Send Email
            $mailer->sendResetPasswordEmail($user);

            $user->setPasswordRequestedAt(new \DateTime());
            $userManager->updateUser($user);
        }

        return new RedirectResponse($this->generateUrl('check_email', ['username' => $username]));
    }

    /**
     * Step 3: Inform user that an email has been sent
     *
     * @param Request $request
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function checkEmail(Request $request)
    {
        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('fos_user_resetting_request'));
        }

        return $this->render('Security/check-email.html.twig', array(
            'tokenLifetime' => ceil($this->ttl / 3600),
        ));
    }

    /**
     * Step 4: Display a form for choose a new password
     *
     * @param Request $request
     * @param $token
     * @param UserManager $userManager
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function reset(Request $request, $token, UserManager $userManager)
    {
        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUserPassword($user);
            $userManager->updateUser($user);

            return $this->redirectToRoute('login');
        }

        return $this->render('Security/reset-password.html.twig', [
           'form' => $form->createView(),
        ]);
    }
}