<?php
namespace Page;

use AbstractFactory;
use Element\ElementEntity;

class PageFactory extends AbstractFactory
{
    public function build(array $content)
    {
        return $this->buildFromString($content);
    }

    public function buildFromString(string $content)
    {
        $page = new PageEntity;
        $element = new ElementEntity;

        $element->setContent($content);

        $page->addElement($element);

        return $page;
    }
}