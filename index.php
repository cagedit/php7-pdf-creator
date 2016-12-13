<pre><?php
use DocumentMaker\DocumentMakerFactory;
use Page\Formats\DocumentFormatsEnum;
use DocumentMaker\DocumentMakerEntity;
use Writer\PdfWriter;
use Writer\WriterInterface;
use File\FileList;
use Presenters\InlinePdfPresenter;

require_once(__DIR__ . '/bootstrap.php');

/** @var DocumentMakerFactory $maker */
$factory = new DocumentMakerFactory;

/** @var DocumentMakerEntity $maker */
$maker = $factory->buildFromArray(DocumentFormatsEnum::A4, [
    ['Doc A P1', 'Doc A P2'],
]);

/** @var WriterInterface $writer */
$writer = (new PdfWriter)->setDirectory('/tmp');

/** @var FileList $writtenFiles */
$writtenFiles = $maker->writeUsing($writer);

$firstFile = $writtenFiles->first();

if (!$firstFile) {
  throw new Exception("No files were written!");
}

echo (new InlinePdfPresenter)->readPdfFile($firstFile);