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
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Behavior\Deleteable;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag implements UserableInterface
{
    use Userable, Deleteable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
}
