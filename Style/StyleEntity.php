<?php
namespace Style;

class StyleEntity implements StyleInterface
{
    private $properties;

    public function addProperty(string $selector, string $property, string $value): StyleInterface
    {
        $this->properties[$selector][$property] = $value;
        return $this;
    }

    public function getProperties(): array
    {
        return $this->properties ?? [];
    }

    public function __toString(): string
    {
        $string = '<style>';
        foreach ($this->getProperties() as $selector => $styles) {
            $string .= $selector . '{';
            foreach ($styles as $property => $value) {
                $string .= $property . ':' . $value . ';';
            }
            $string .= '}';
        }
        $string .= '</style>';
        return $string;
    }
}