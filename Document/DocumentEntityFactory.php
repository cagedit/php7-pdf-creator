<?php
namespace Document;

use Page\Formats\FormatInterface;
use Page\PageFactory;

class DocumentEntityFactory
{
    public function buildFromArray(FormatInterface $format, array $pages)
    {
        $entity = new DocumentEntity;

        foreach ($pages as $page) {
            $pageEntity = (new PageFactory)
                ->buildFromString($page)
                ->setFormat($format);

            $entity->addPage($pageEntity);
        }

        return $entity;
    }
}