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
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
    public function search(array $tags = [])
    {
        /** @var Document[] $documents */
        $documents = $this->documentRepository->searchByTags($tags);

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
