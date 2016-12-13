<?php
namespace DocumentMaker;

use Document\DocumentInterface;
use DocumentMakerInterface;
use Element\ElementInterface;
use File\FileListInterface;
use Illuminate\Log\Writer;
use Page\Formats\Dimension;
use Page\Formats\FormatInterface;
use StringableTrait;
use StringableInterface;
use Style\DocumentStyleFactory;
use Writer\WriterInterface;

class DocumentMakerEntity implements DocumentMakerInterface, StringableInterface
{
    use StringableTrait;

    private $documents;

    /** @var FormatInterface */
    private $format;

    private $footer;

    private $footerHeight;


    public function addDocument(DocumentInterface $document)
    {
        $this->documents[] = $document;
    }

    public function getDocuments(): array
    {
        return $this->documents ?? [];
    }

    public function writeUsing(WriterInterface $writer): FileListInterface
    {
        $writer->setFormat($this->getFormat());

        /** @var DocumentInterface $document */
        foreach ($this->getDocuments() as $document) {

            $writer->write($this->getDocumentStyle($document) . $document);
        }

        return $writer->persist();
    }

    /**
     * @param DocumentInterface $document
     * @return \Style\StyleInterface
     */
    private function getDocumentStyle($document)
    {
        return (new DocumentStyleFactory)->build([
            'format' => $this->getFormat(),
            'pageCount' => count($document->getPages())
        ]);
    }

    public function getItems(): array
    {
        $this->prepareDocuments();
        return $this->getDocuments();
    }

    public function setFormat(FormatInterface $format): DocumentMakerInterface
    {
        $this->format = $format;
        return $this;
    }

    public function getFormat(): FormatInterface
    {
        return $this->format;
    }

    public function setFooter(ElementInterface $footer, Dimension $footerHeight): DocumentMakerInterface
    {
        $this->footer = $footer;
        $this->footerHeight = $footerHeight;

        return $this;
    }

    public function getFooter()
    {
        return $this->footer ?? false;
    }

    public function getFooterHeight()
    {
        return $this->footerHeight;
    }

    private function prepareDocuments()
    {
        /** @var DocumentInterface $document */
        foreach ($this->getDocuments() as $document) {
            $document->prepare($this);
        }
    }


}