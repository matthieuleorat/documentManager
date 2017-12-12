<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 09/12/17
 * Time: 08:36
 */

namespace tests\Entity;

use App\Entity\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testGetId()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getId());
    }

    public function testGetName()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getName());
    }

    public function testSetName()
    {
        $name = "Document Name";
        $document = $this->getDocument();
        $document->setName($name);
        $this->assertEquals($name, $document->getName());
    }

    public function testDescription()
    {
        $description = "Document description";
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getDescription());
        $document->setDescription($description);
        $this->assertEquals($description, $document->getDescription());
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|Document
     */
    protected function getDocument()
    {
        return $this->getMockForAbstractClass(Document::class);
    }
}
