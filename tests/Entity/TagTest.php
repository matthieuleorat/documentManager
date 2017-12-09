<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 09/12/17
 * Time: 08:36
 */

namespace tests\Entity;

use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testGetId()
    {
        $tag = $this->getTag();
        $this->assertEquals(NULL, $tag->getId());
    }

    public function testGetName()
    {
        $tag = $this->getTag();
        $this->assertEquals(NULL, $tag->getName());
    }

    public function testSetName()
    {
        $name = "Tag Name";
        $tag = $this->getTag();
        $tag->setName($name);
        $this->assertEquals($name, $tag->getName());
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|Tag
     */
    protected function getTag()
    {
        return $this->getMockForAbstractClass(Tag::class);
    }
}
