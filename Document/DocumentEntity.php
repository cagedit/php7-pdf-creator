<?php
namespace Document;

use Maker\DocumentMakerInterface;
use Page\Formats\Dimension;
use Page\Formats\FormatInterface;
use Page\PageInterface;
use StringableInterface;
use StringableTrait;

class DocumentEntity implements DocumentInterface, StringableInterface
{
    use StringableTrait;

    /** @var array */
    private $pages;

    /** @var FormatInterface */
    private $format;

    /** @var DocumentMakerInterface */
    private $maker;

    public function setMaker(DocumentMakerInterface $maker)
    {
        $this->maker = $maker;
    }

    public function getMaker(): DocumentMakerInterface
    {
        return $this->maker;
    }

    public function addPage(PageInterface $page)
    {
        $this->pages[] = $page;
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function getItems(): array
    {
        return $this->getPages();
    }

    public function setFormat(FormatInterface $format)
    {
        if (is_null($this->format)) {
            $this->format = $format;
        }

        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getFooter()
    {
        return $this->getMaker()->getFooter();
    }

    public function getFooterHeight(): Dimension
    {
        return $this->getMaker()->getFooterHeight() ?? new Dimension(0, 'px');
    }

    public function getHeader()
    {
        return $this->getMaker()->getHeader();
    }

    public function getHeaderHeight(): Dimension
    {
        return $this->getMaker()->getHeaderHeight() ?? new Dimension(0, 'px');
    }


    public function hasHeader(): bool
    {
        return $this->getHeader() !== false;
    }

    public function hasFooter(): bool
    {
        return $this->getFooter() !== false;
    }
}