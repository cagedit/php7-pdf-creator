<?php
use DocumentMaker\DocumentMakerFactory;
use Page\Formats\DocumentFormatsEnum;
use DocumentMaker\DocumentMakerEntity;
use Writer\PdfWriter;
use Writer\WriterInterface;

require_once(__DIR__ . '/bootstrap.php');

/** @var DocumentMakerFactory $maker */
$factory = new DocumentMakerFactory;

/** @var DocumentMakerEntity $maker */
$maker = $factory->buildFromArray(DocumentFormatsEnum::A4, [
    ['Doc A P1', 'Doc A P2'], ['Doc B'], ['Doc C']
]);

/** @var WriterInterface $writer */
$writer = (new PdfWriter)->setDirectory('/tmp');

$maker->writeUsing($writer);

echo $document;