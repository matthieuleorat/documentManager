<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 09/12/17
 * Time: 08:36
 */

namespace tests\Entity;

use App\Entity\Document;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testConstruct()
    {
        $document = $this->getDocument();
        $this->assertInstanceOf(ArrayCollection::class, $document->getTags());
    }

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

    public function testTags()
    {
        $document = $this->getDocument();
        $tag1 = $this->newTag('tag1');
        $tag2 = $this->newTag('tag2');

        $document->addTag($tag1);
        $this->assertEquals(1, $document->getTags()->count());

        $document->removeTag($tag1);
        $this->assertEquals(0, $document->getTags()->count());

        $document->setTags(new ArrayCollection([$tag1, $tag2]));
        $this->assertEquals(2, $document->getTags()->count());
    }

    public function testFile()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getFile());

        $file = "my-file.pdf";
        $document->setFile($file);
        $this->assertEquals($file, $document->getFile());
    }

    public function testOriginalFileName()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getOriginalFileName());

        $file = "my-file-name.pdf";
        $document->setOriginalFileName($file);
        $this->assertEquals($file, $document->getOriginalFileName());
    }

    public function testPath()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getPath());

        $path = "/path";
        $document->setPath($path);
        $this->assertEquals($path, $document->getPath());
    }

    public function testThumbnail()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getThumbnail());

        $thumbnail = "/path-to-thumnail";
        $document->setThumbnail($thumbnail);
        $this->assertEquals($thumbnail, $document->getThumbnail());
    }

    public function testThumbnailPath()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getFullThumbnailPath());

        $thumbnailpath = "/path-to-thumnail";
        $document->setFullThumbnailPath($thumbnailpath);
        $this->assertEquals($thumbnailpath, $document->getFullThumbnailPath());
    }

    public function testUser()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getUser());

        $user = $this->newUser();
        $document->setUser($user);
        $this->assertEquals($user, $document->getUser());
    }

    public function testDate()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getCreatedAt());
        $this->assertEquals(NULL, $document->getUpdatedAt());

        $document->created();
        $this->assertInstanceOf(\DateTime::class, $document->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $document->getUpdatedAt());

        $document->updated();
        $this->assertGreaterThan($document->getCreatedAt(), $document->getUpdatedAt());

        $createdAt = new \DateTime();
        $document->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $document->getCreatedAt());

        $document->setUpdatedAt($createdAt);
        $this->assertEquals($createdAt, $document->getUpdatedAt());
    }

    public function testDelete()
    {
        $document = $this->getDocument();
        $this->assertEquals(NULL, $document->getOldId());

        $document->setOldId();
        $this->assertEquals($document->getId(), $document->getOldId());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Document
     */
    protected function getDocument()
    {
        return $this->getMockForAbstractClass(Document::class);
    }

    /**
     * @param $name
     * @return Tag
     */
    protected function newTag($name)
    {
        /** @var Tag $tag */
        $tag = $this->getMockForAbstractClass(Tag::class);
        $tag->setName($name);

        return $tag;
    }

    protected function newUser()
    {
        /** @var User $user */
        $user = $this->getMockForAbstractClass(User::class);

        return $user;
    }
}
