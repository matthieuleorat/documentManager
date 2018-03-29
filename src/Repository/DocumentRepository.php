<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/03/18
 * Time: 14:50
 */

namespace App\Repository;

use App\Entity\Document;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DocumentRepository extends ServiceEntityRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * DocumentRepository constructor.
     * @param RegistryInterface $registry
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(RegistryInterface $registry, TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        parent::__construct($registry, Document::class);
    }

    /**
     * @param array $tags
     * @return array
     */
    public function searchByTags($tags = [])
    {
        $qb = $this->createQueryBuilder('d')
            ->where('d.user = :user')
            ->setParameter(':user', $this->user)
            ->orderBy('d.id', 'ASC');

        if (false === empty($tags)) {
            foreach ($tags as $tag) {
                $qb->andWhere($qb->expr()->isMemberOf(':tag_'.$tag->getId(), 'd.tags'))
                    ->setParameter('tag_'.$tag->getId(), $tag);
            }
        }

        return $qb->getQuery()->execute();
    }

    public function getTagsIds($tags = [])
    {
        $qb = $this->createQueryBuilder('d')
            ->select('tags.id')
            ->where('d.user = :user')
            ->innerJoin('d.tags','tags')
            ->setParameter(':user', $this->user)
            ->groupBy('tags.id');

        if (false === empty($tags)) {
            foreach ($tags as $tag) {
                $qb->andWhere($qb->expr()->isMemberOf(':tag_'.$tag->getId(), 'd.tags'))
                    ->setParameter('tag_'.$tag->getId(), $tag);
            }
        }

        return $qb->getQuery()->execute();
    }
}
