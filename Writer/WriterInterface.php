<?php
namespace Writer;

use Maker\DocumentMakerInterface;
use Page\Formats\FormatInterface;

interface WriterInterface
{
    public function write(string $data);
    public function persist();
    public function setFormat(FormatInterface $format): WriterInterface;
    public function setMaker(DocumentMakerInterface $maker): WriterInterface;
}