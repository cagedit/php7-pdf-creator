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

$maker->buildFromArray(DocumentFormatsEnum::A4, [
    ['test', 'Doc A P2'],
    ['abc']
]);

/** @var ElementEntity $footer */
$footer = (new ElementEntity)
    ->setContent('Page [pageNum] of [pageCount]')
    ->addStyle('text-align', 'center');

$maker->setFooter(
    $footer,
    new Dimension(30, 'px')
);

$header = (new ElementEntity)->setContent('This is the header');
$maker->setHeader(
    $header,
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