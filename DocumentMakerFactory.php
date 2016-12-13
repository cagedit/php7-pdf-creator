<?php
namespace DocumentMaker;

use Document\DocumentEntityFactory;
use Element\ElementEntity;
use Page\Formats\Dimension;
use Page\Formats\FormatFactory;
use Page\Formats\FormatInterface;

class DocumentMakerFactory
{
    public function buildFromArray(string $format, array $documents)
    {
        $format = $this->buildDocumentFormat($format);

        $maker = (new DocumentMakerEntity)->setFormat($format);

        $footer = (new ElementEntity)->setContent('Page [page_number] of [page_count]');
        $footerHeight = new Dimension(1, 'in');

        foreach ($documents as $document) {
            $docEntity = (new DocumentEntityFactory)
                ->buildFromArray($format, $document)
                ->setFooter($footer, $footerHeight);

            $maker->addDocument($docEntity);
        }

        return $maker;

    }

    private function buildDocumentFormat($format): FormatInterface
    {
        return (new FormatFactory)->make($format);
    }
}