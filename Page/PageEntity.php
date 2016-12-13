<?php
namespace Page;

use Element\ElementInterface;
use Page\Formats\FormatInterface;
use StringableTrait, StringableInterface;

class PageEntity implements PageInterface, StringableInterface
{
    use StringableTrait;

    private $elements;

    /** @var FormatInterface */
    private $format;

    public function addElement(ElementInterface $element)
    {
        $this->elements[] = $element;
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
        return $this->format->wrapContent($content);
    }
}