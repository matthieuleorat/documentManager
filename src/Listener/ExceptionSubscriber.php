<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 26/01/18
 * Time: 08:48
 */

namespace App\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface  */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            KernelEvents::EXCEPTION => array(
                array('processException', 10),
                array('logException', 0),
                array('notifyException', -10),
            )
        );
    }

    public function processException(GetResponseForExceptionEvent $event)
    {
        // ...
    }

    public function logException(GetResponseForExceptionEvent $event)
    {
        $this->logger->error($event->getException()->getMessage());
    }

    public function notifyException(GetResponseForExceptionEvent $event)
    {
        // ...
    }
}