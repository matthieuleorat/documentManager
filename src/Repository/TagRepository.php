<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/03/18
 * Time: 14:50
 */

namespace App\Repository;


use App\Entity\Document;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * @param Tags[]|ArrayCollection $tags
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function search($tags = [])
    {
        $subQuery = $this->_em->createQueryBuilder()
            ->select('d')
            ->from(Document::class, 'd')
            ->where('1 = 1');

        foreach ($tags as $tag) {
            $subQuery->andWhere($subQuery->expr()->isMemberOf(':tag_'.$tag->getId(), 'd.tags'))
                ->setParameter('tag_'.$tag->getId(), $tag);
        }

        /** @var Document[] $documents */
        $documents = $subQuery->getQuery()->getResult();
        $tagsId = [];
        foreach ($documents as $document) {
            foreach ($document->getTags() as $tag) {
                $tagsId[$tag->getId()] = $tag->getId();
            }
        }

        $qb = $this->createQueryBuilder('t')
            ->where('t.id in (:tags_id)')
            ->setParameter('tags_id', $tagsId);
        ;

        return $qb;
    }
}
