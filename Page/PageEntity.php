<?php
namespace Page;

use Document\DocumentInterface;
use Element\ElementInterface;
use Page\Formats\Dimension;
use Page\Formats\FormatInterface;
use StringableTrait, StringableInterface;
use Element\ElementEntity;

class PageEntity implements PageInterface, StringableInterface
{
    use StringableTrait;

    private $elements;

    /** @var DocumentInterface */
    private $document;

    /** @var FormatInterface */
    private $format;

    /** @var int */
    private $pageNumber;

    public function setDocument(DocumentInterface $document): PageInterface
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): DocumentInterface
    {
        return $this->document;
    }

    public function addElement(ElementInterface $element): PageInterface
    {
        $this->elements[] = $element;
        return $this;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function setFormat(FormatInterface $format)
    {
        $this->format = $format;
        return $this;
    }

    public function setPageNumber(int $number): PageInterface
    {
        $this->pageNumber = $number;
        return $this;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public function getFormat(): FormatInterface
    {
        return $this->format;
    }

    public function getItems(): array
    {
        return $this->getElements();
    }

    public function finalize($content)
    {
        return $this->wrapPage($content);
    }

    private function getWrapper(): ElementInterface
    {
        /** @var FormatInterface $format */
        $format = $this->getFormat();

        /** @var Dimension $height */
        $height = $format->getHeight();

        if ($this->getDocument()->hasHeader()) {
            $height = $height->subtract($this->getDocument()->getHeaderHeight());
        }

        if ($this->getDocument()->hasFooter()) {
            $height = $height->subtract($this->getDocument()->getFooterHeight());
        }

        return (new ElementEntity)
            ->setId('body')
            ->addStyle('width', $format->getWidth()->toPixelsString())
            ->addStyle('height', $height->toPixelsString())
            ->addStyle('overflow', 'hidden')
            ->addStyle('background', '#' . mt_rand(333, 999))
            ->addStyle('position', 'relative');
    }

    public function wrapPage(string $content): string
    {
        $wrapper = $this->getWrapper()->setContent($content);

        if ($header = $this->getDocument()->getHeader()) {
            $wrapper->prepend($this->buildHeader($header, $this->getDocument()->getHeaderHeight()));
        }

        if ($footer = $this->getDocument()->getFooter()) {
            $wrapper->append($this->buildFooter($footer, $this->getDocument()->getFooterHeight()));
        }

        return $wrapper;
    }

    /**
     * @param ElementInterface $header
     * @param Dimension $headerHeight
     * @return mixed
     */
    private function buildHeader($header, $headerHeight)
    {
        return $header
            ->setId('header')
            ->addStyle('height', $headerHeight->toPixelsString())
            ->addStyle('width', $this->getFormat()->getWidth()->toPixelsString())
            ->addStyle('display', 'inline-block')
            ->addStyle('background-color', 'red');
    }

    /**
     * @param ElementInterface $footer
     * @param Dimension $footerHeight
     * @return mixed
     */
    private function buildFooter($footer, $footerHeight)
    {
        $document = $this->getDocument();
        $pageCount = count($document->getPages());
        $content = str_replace(
            ['pageNum', 'pageCount'],
            [$this->getPageNumber(), $pageCount],
            $footer->getContent()
        );

        return $footer->clone()
            ->setId('footer')
            ->addStyle('height', $footerHeight->toPixelsString())
            ->addStyle('width', $this->getFormat()->getWidth()->toPixelsString())
            ->addStyle('display', 'inline-block')
            ->addStyle('background-color', 'red')
            ->setContent($content);
    }
}