<?php
namespace Document;

use Element\ElementInterface;
use Page\Formats\Dimension;
use Page\Formats\FormatInterface;
use Page\PageInterface;
use StringableInterface;
use StringableTrait;
use DocumentMakerInterface;

class DocumentEntity implements DocumentInterface, StringableInterface
{
    use StringableTrait;

    private $pages;

    /** @var FormatInterface */
    private $format;

    /** @var ElementInterface */
    private $footer;

    /** @var Dimension */
    private $footerHeight;

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

    public function setFooter(ElementInterface $footer, Dimension $footerHeight): DocumentInterface
    {
        $this->footer = $footer;
        $this->footerHeight = $footerHeight;

        return $this;
    }

    public function getFooter(): ElementInterface
    {
        return $this->footer;
    }


    public function prepare(DocumentMakerInterface $maker): DocumentInterface
    {
        if ($maker->getFooter()) {
            $this->setFooter($maker->getFooter(), $maker->getFooterHeight());
        }

    }


}