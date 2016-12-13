<?php
namespace Style;

interface StyleInterface
{
    public function addProperty(string $selector, string $property, string $value): StyleInterface;
    public function __toString(): string;
}