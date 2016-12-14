<?php
namespace Document;

use Page\Formats\Dimension;
use Page\PageInterface;

interface DocumentInterface
{
    public function addPage(PageInterface $page);
    public function getPages(): array;
    public function getFooter();
    public function getFooterHeight(): Dimension;
    public function getHeader();
    public function getHeaderHeight(): Dimension;
    public function hasHeader(): bool;
    public function hasFooter(): bool;

}