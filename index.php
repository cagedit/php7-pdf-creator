<?php
use File\FileList;
use Maker\DocumentMakerFactory;
use Maker\DocumentMakerEntity;
use Page\Formats\DocumentFormatsEnum;
use Writer\PdfWriter;
use Writer\WriterInterface;
use Presenters\InlinePdfPresenter;
use Element\ElementEntity;
use Page\Formats\Dimension;

require_once(__DIR__ . '/bootstrap.php');

/** @var DocumentMakerEntity $maker */
$maker = new DocumentMakerEntity;

$pages[] = ['Doc1 Page1', 'Doc1 Page2'];
$pages[] = ['Doc2'];

$pages[] = [
    (new ElementEntity)->setContent('This element has style')
        ->addStyle('background-color', 'blue')
        ->addStyle('color', '#FFF')
];

$maker->buildFromArray(DocumentFormatsEnum::A4, $pages);

/** @var ElementEntity $footer */
$footer = (new ElementEntity)
    ->setContent('Page pageNum of pageCount')
    ->addStyle('text-align', 'center');

$maker->setFooter(
    $footer,
    new Dimension(30, 'px')
);

/** @var WriterInterface $writer */
$writer = (new PdfWriter)->setDirectory('/tmp');

/** @var FileList $writtenFiles */
$writtenFiles = $maker->writeUsing($writer);

$firstFile = $writtenFiles->first();

if (!$firstFile) {
  throw new Exception("No files were written!");
}

echo (new InlinePdfPresenter)->readPdfFile($firstFile);