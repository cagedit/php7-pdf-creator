<?php
namespace Page;

use Element\ElementInterface;

interface PageInterface
{
    public function addElement(ElementInterface $element);
}