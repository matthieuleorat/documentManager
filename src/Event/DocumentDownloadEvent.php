<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 08/12/17
 * Time: 08:22
 */

namespace App\Event;

use App\Entity\Document;
use Symfony\Component\EventDispatcher\Event;

class DocumentDownloadEvent extends Event
{
    /** @var Document  */
    private $document;

    /**
     * DocumentDownloadEvent constructor.
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param Document $document
     */
    public function setDocument(Document $document)
    {
        $this->document = $document;
    }
}
