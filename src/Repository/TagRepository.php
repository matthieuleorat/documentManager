<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/03/18
 * Time: 14:50
 */

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TagRepository extends ServiceEntityRepository
{
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * TagRepository constructor.
     * @param RegistryInterface $registry
     * @param DocumentRepository $documentRepository
     */
    public function __construct(RegistryInterface $registry, DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
        parent::__construct($registry, Tag::class);
    }

    /**
     * @param Tag[] $tags
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAvailableTags(array $tags = [])
    {
        $tagsId = array_column($this->documentRepository->getTagsIds($tags), 'id');

        $qb = $this->createQueryBuilder('t')
            ->where('t.id in (:tags_id)')
            ->setParameter('tags_id', $tagsId);
        ;

        $qb->orderBy('t.name','ASC');

        return $qb;
    }
}
