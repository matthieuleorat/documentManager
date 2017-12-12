<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/12/17
 * Time: 07:39
 */

namespace App\Entity\Behavior;

trait Deleteable
{
    /**
     * @var integer
     */
    private $oldId;

    /**
     * @return int
     */
    public function getOldId()
    {
        return $this->oldId;
    }

    /**
     * @return mixed
     */
    public function setOldId()
    {
        $this->oldId = $this->id;
        return $this;
    }
}
