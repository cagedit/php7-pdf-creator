<?php
namespace Document;
use Element\ElementInterface;
use Page\Formats\Dimension;
use Page\PageInterface;
use DocumentMakerInterface;

interface DocumentInterface
{
    public function addPage(PageInterface $page);
    public function getPages(): array;
    public function prepare(DocumentMakerInterface $maker): DocumentInterface;
    public function setFooter(ElementInterface $footer, Dimension $footerHeight): DocumentInterface;
    public function getFooter(): ElementInterface;

}