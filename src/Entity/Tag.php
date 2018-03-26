<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 21/11/17
 * Time: 18:56
 */

namespace App\Entity;

use App\Entity\Behavior\Userable;
use App\Entity\Behavior\UserableInterface;
use App\Entity\Behavior\Deleteable;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tag")
 * @ApiResource()
 */
class Tag implements UserableInterface
{
    use Userable, Deleteable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"document_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"document_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=7)
     * @Groups({"document_read"})
     */
    private $color;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->color = dechex(rand(0x000000, 0xFFFFFF));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     * @return Tag
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }
}
