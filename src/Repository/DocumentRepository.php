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

    public function searchByTags(array $tags)
    {
        $qb = $this->createQueryBuilder('d')
            ->orderBy('d.id', 'ASC');

        if (false === empty($tags)) {
            $qb
                ->leftJoin('d.tags','t')
                ->where('t.id in (:tags)')
                ->setParameter(':tags', $tags)
            ;
        }

        return $qb->getQuery()->execute();
    }
}
