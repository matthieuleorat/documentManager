<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 19/11/17
 * Time: 19:38
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Behavior\Timestampable;
use App\Entity\Behavior\Userable;
use App\Entity\Behavior\UserableInterface;
use App\Entity\Behavior\Deleteable;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     attributes={
 *          "normalization_context"={"groups"={"document_read"}}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "normalization_context"={"groups"={"document_read"}}},
 *          "delete"={"method"="DELETE"},
 *          "put"={"method"="PUT"},
 *          "download"={"route_name"="document_download"}
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @ORM\Table(name="document")
 * @ORM\HasLifecycleCallbacks()
 */
class Document implements UserableInterface
{
    use Userable, Timestampable, Deleteable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"document_read"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     * @Groups({"document_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $originalFileName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $path;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", cascade={"persist"}, fetch="EAGER")
     * @ApiSubresource()
     * @Groups({"document_read"})
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"document_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $thumbnail;

    /**
     * @var string
     * @Groups({"document_read"})
     */
    private $fullThumbnailPath;

    /**
     * Document constructor.
     *
     * Init tags with an empty array collection
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Document
     */
    public function setName(string $name) : Document
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);

        return $this;
    }

    /**
     * @param Tag[]|ArrayCollection $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string|File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    /**
     * @param string|null $originalFileName
     * @return Document
     */
    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return Document
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullThumbnailPath()
    {
        return $this->fullThumbnailPath;
    }

    /**
     * @param mixed $fullThumbnailPath
     * @return Document
     */
    public function setFullThumbnailPath($fullThumbnailPath)
    {
        $this->fullThumbnailPath = $fullThumbnailPath;
        return $this;
    }
}
