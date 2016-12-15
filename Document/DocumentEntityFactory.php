<?php
namespace Document;

use Page\Formats\FormatInterface;
use Page\PageFactory;

class DocumentEntityFactory
{

    public function buildFromArray(FormatInterface $format, array $pages)
    {
        $entity = new DocumentEntity;

        foreach (array_values($pages) as $index => $page) {
            $pageEntity = (new PageFactory)
                ->buildFromString($page)
                ->setFormat($format)
                ->setPageNumber(++$index)
                ->setDocument($entity);

            $entity->addPage($pageEntity);
        }

        return $entity;
    }
}