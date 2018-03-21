<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 20/03/18
 * Time: 08:38
 */

namespace App\Entity;

use App\Entity\Behavior\Deleteable;
use App\Entity\Behavior\Timestampable;
use App\Entity\Behavior\Userable;
use App\Entity\Behavior\UserableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 * @ORM\HasLifecycleCallbacks()
 */
class Folder implements UserableInterface
{
    use Userable, Timestampable, Deleteable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="App\Entity\Document")
     */
    private $documents;

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
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param $documents
     * @return $this
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;

        return $this;
    }
}