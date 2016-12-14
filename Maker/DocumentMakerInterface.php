<?php
namespace Maker;

use Document\DocumentInterface;
use Writer\WriterInterface;
use File\FileListInterface;
use Element\ElementInterface;
use Page\Formats\Dimension;

interface DocumentMakerInterface
{
    public function addDocument(DocumentInterface $document);
    public function getDocuments(): array;
    public function writeUsing(WriterInterface $writer): FileListInterface;
    public function setFooter(ElementInterface $footer, Dimension $footerHeight): DocumentMakerInterface;
    public function getFooter();
    public function getFooterHeight(): Dimension;
}