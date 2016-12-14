<?php
namespace Element;

interface ElementInterface
{
    public function setContent(string $content): ElementInterface;
    public function getContent(): array;
    public function append(ElementInterface $element): ElementInterface;
    public function prepend(ElementInterface $element): ElementInterface;
    public function addStyle(string $property, string $value): ElementInterface;

}