<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/12/17
 * Time: 07:24
 */

namespace App\Listener\Doctrine;

use App\Entity\Tag;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class DoctrineTagSubscriber implements EventSubscriber
{

    /** @var LoggerInterface  */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'postPersist',
            'postUpdate',
            'postRemove',
        );
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        /** @var Tag $object */
        if (false === ($object = $this->isTag($args))) {
            return;
        }

        // Init oldId
        $object->setOldId();
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        /** @var Tag $object */
        if (false === ($object = $this->isTag($args))) {
            return;
        }

        $this->logger->info('create', ['tag' => $object->getId(), 'user' => $object->getUser()->getId()]);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        /** @var Tag $object */
        if (false === ($object = $this->isTag($args))) {
            return;
        }

        $this->logger->info('edit', ['tag' => $object->getId(), 'user' => $object->getUser()->getId()]);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        /** @var Tag $object */
        if (false === ($object = $this->isTag($args))) {
            return;
        }

        $this->logger->info('remove', ['tag' => $object->getOldId(), 'user' => $object->getUser()->getId()]);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return bool|Tag
     */
    private function isTag(LifecycleEventArgs $args)
    {
        /** @var Tag|bool $tag */
        if (false === ($tag = $args->getObject()) instanceof Tag) {
            return false;
        }

        return $tag;
    }
}
