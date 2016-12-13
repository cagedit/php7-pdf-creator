<?php
namespace Element;

use StringableInterface, StringableTrait;

class ElementEntity implements ElementInterface, StringableInterface
{
    use StringableTrait;

    private $content;
    private $attributes;

    public function setContent(string $content): ElementInterface
    {
        $this->content[] = $content;
        return $this;
    }

    public function getContent(): array
    {
        return $this->content ?? [];
    }

    public function setAttribute($name, $value)
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

    public function addStyle($property, $value)
    {
        $style = $this->getAttribute('style');

        $this->setAttribute('style', "{$style}{$property}:{$value};");

        return $this;
    }

    public function finalize($content)
    {
        $div = "<div ";
        foreach ($this->getAttributes() as $name => $value) {
            $div .= "{$name}=\"{$value}\" ";
        }

        $div .= ">{$content}</div>";

        return $div;
    }

    public function getItems(): array
    {
        return $this->getContent();
    }
}