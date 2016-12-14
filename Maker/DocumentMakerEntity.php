<?php
namespace Maker;

use Document\DocumentEntityFactory;
use Document\DocumentInterface;
use Element\ElementInterface;
use File\FileListInterface;
use Page\Formats\Dimension;
use Page\Formats\FormatInterface;
use StringableTrait;
use StringableInterface;
use Style\DocumentStyleFactory;
use Style\StyleInterface;
use Writer\WriterInterface;
use Page\Formats\FormatFactory;


class DocumentMakerEntity implements DocumentMakerInterface, StringableInterface
{
    use StringableTrait;

    /** @var array */
    private $documents;

    /** @var FormatInterface */
    private $format;

    /** @var ElementInterface */
    private $footer;

    /** @var Dimension */
    private $footerHeight;

    private $header;

    private $headerHeight;


    public function addDocument(DocumentInterface $document)
    {
        $this->documents[] = $document;
    }

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents ?? [];
    }

    public function writeUsing(WriterInterface $writer): FileListInterface
    {
        $writer->setFormat($this->getFormat())
            ->setMaker($this);

        /** @var DocumentInterface $document */
        foreach ($this->getDocuments() as $document) {

            $writer->write($this->buildDocumentStyle($document) . $document);
        }

        return $writer->persist();
    }

    /**
     * @param DocumentInterface $document
     * @return StyleInterface
     */
    private function buildDocumentStyle($document)
    {
        return (new DocumentStyleFactory)->build([
            'format' => $this->getFormat(),
            'pageCount' => count($document->getPages())
        ]);
    }

    public function getItems(): array
    {
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

    public function getFooterHeight(): Dimension
    {
        return $this->footerHeight;
    }

    public function setHeader(ElementInterface $header, Dimension $headerHeight): DocumentMakerInterface
    {
        $this->header = $header;
        $this->headerHeight = $headerHeight;

        return $this;
    }

    public function getHeader()
    {
        return $this->header ?? false;
    }

    public function getHeaderHeight()
    {
        return $this->headerHeight;
    }

    private function buildDocumentFormat($format): FormatInterface
    {
        return (new FormatFactory)->make($format);
    }

    public function buildFromArray(string $format, array $documents): DocumentMakerInterface
    {
        $format = $this->buildDocumentFormat($format);

        $this->setFormat($format);

        foreach ($documents as $document) {
            $docEntity = (new DocumentEntityFactory)
                ->buildFromArray($format, $document);

            $docEntity->setMaker($this);

            $this->addDocument($docEntity);
        }

        return $this;

    }

}