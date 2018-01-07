<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 07/01/18
 * Time: 18:02
 */

namespace App\Listener\Security;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class LoginFailedListener
{
    /** @var LoggerInterface  */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $this->logger->error($event->getAuthenticationException()->getMessage().' - Try to loggin with '.$event->getAuthenticationToken()->getUsername());
    }
}
