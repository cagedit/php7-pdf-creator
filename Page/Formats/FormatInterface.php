<?php
namespace Page\Formats;

interface FormatInterface
{
    public function getHeight(): Dimension;
    public function getWidth(): Dimension;
    public function getPaperSizeArray(): array;
}