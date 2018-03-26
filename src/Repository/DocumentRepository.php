<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/03/18
 * Time: 14:50
 */

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function searchByTags($tags = [])
    {
        $qb = $this->createQueryBuilder('d')
            ->where('1 = 1')
            ->orderBy('d.id', 'ASC');

        if (false === empty($tags)) {
            foreach ($tags as $tag) {
                $qb->andWhere($qb->expr()->isMemberOf(':tag_'.$tag->getId(), 'd.tags'))
                    ->setParameter('tag_'.$tag->getId(), $tag);
            }
        }

        return $qb->getQuery()->execute();
    }
}
