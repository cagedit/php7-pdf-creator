<?php
namespace Page\Formats;

interface FormatInterface
{
    public function getHeight();
    public function getWidth();
    public function wrapContent(string $content);
    public function getPaperSizeArray(): array;
}