<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/11/17
 * Time: 12:29
 */

namespace App\Listener;

use App\Entity\Behavior\UserableInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    /** @var TokenStorageInterface  */
    private $tokenStorage;

    /**
     * TagSubscriber constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist'    => ['prePersist'],
        );
    }

    public function prePersist(GenericEvent $event)
    {
        $this->setUser($event->getSubject());
    }

    /**
     * @param Object|UserableInterface $entity
     */
    private function setUser($entity)
    {
        if (false === ($entity instanceof UserableInterface)) {
            return;
        }

        $entity->setUser($this->tokenStorage->getToken()->getUser());
    }
}
