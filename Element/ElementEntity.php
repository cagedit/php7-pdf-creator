<?php
namespace Element;

use StringableInterface, StringableTrait;

class ElementEntity implements ElementInterface, StringableInterface
{
    use StringableTrait;

    private $content;
    private $attributes;
    private $appended;
    private $prepended;

    public function setContent(string $content): ElementInterface
    {
        $this->content[] = $content;
        return $this;
    }

    public function getContent(): array
    {
        return $this->content ?? [];
    }

    public function setId(string $id)
    {
        $this->setAttribute('id', $id);
        return $this;
    }

    public function setAttribute(string $name, string $value): ElementInterface
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes ?? [];
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name] ?? '';
    }

    public function elementToString($content): string
    {
        $elem = "<div ";
        foreach ($this->getAttributes() as $name => $value) {
            $elem .= "{$name}=\"{$value}\" ";
        }

        $elem .= ">{$content}</div>";

        return $elem;
    }

    public function addStyle(string $property, string $value): ElementInterface
    {
        $style = $this->getAttribute('style');

        $this->setAttribute('style', "{$style}{$property}:{$value};");

        return $this;
    }

    public function finalize($content)
    {
        $allElements = array_merge($this->getPrepended(), [$this->elementToString($content)], $this->getAppended());

        return implode('', $allElements);
    }

    public function getItems(): array
    {
        return $this->getContent();
    }

    public function append(ElementInterface $item): ElementInterface
    {
        $this->appended[] = $item;
        return $this;
    }

    public function getAppended(): array
    {
        return $this->appended ?? [];
    }

    public function prepend(ElementInterface $item): ElementInterface
    {
        $this->prepended[] = $item;
        return $this;
    }

    public function getPrepended(): array
    {
        return $this->prepended ?? [];
    }
}