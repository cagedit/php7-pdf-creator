<?php
namespace Style;

use AbstractFactory;
use Page\Formats\Dimension;

class DocumentStyleFactory extends AbstractFactory
{

    public function build(array $data)
    {
        /** @var Dimension $pageHeight */
        $pageHeight = $data['format']->getHeight();

        $docHeight = $pageHeight->getPixels() * $data['pageCount'] . 'px';

        return (new StyleEntity)
            ->addProperty('body,html', 'margin', 0)
            ->addProperty('body,html', 'padding', 0)
            ->addProperty('body,html', 'height', $docHeight)
            ->addProperty('body,html', 'max-height', $docHeight)
            ->addProperty('body,html', 'overflow', 'hidden')
            ;
    }
}