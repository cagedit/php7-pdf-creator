<?php
namespace Page\Formats;

use Element\ElementEntity;
use Element\ElementInterface;

class BaseFormat
{
    protected $height = 0.0;
    protected $width  = 0.0;

    protected $dimensions;

    /**
     * @return Dimension
     */
    public function getHeight(): Dimension
    {
        return $this->getDimensions()['height'];
    }

    /**
     * @return Dimension
     */
    public function getWidth(): Dimension
    {
        return $this->getDimensions()['width'];
    }

    /**
     * @return array
     */
    public function getDimensions(): array
    {
        if (is_null($this->dimensions)) {
            $this->dimensions = [
                'height' => new Dimension($this->height, 'in'),
                'width'  => new Dimension($this->width, 'in')
            ];
        }

        return $this->dimensions;
    }

    private function getWrapper(): ElementInterface
    {
        return (new ElementEntity)
            ->addStyle('width', $this->getWidth()->toPixelsString())
            ->addStyle('height', $this->getHeight()->toPixelsString())
            ->addStyle('overflow', 'hidden')
            ->addStyle('background', '#999')
            ->addStyle('position', 'relative');
    }

    public function wrapContent(string $content): string
    {
        return $this->getWrapper()->setContent($content);
    }

    public function getPaperSizeArray(): array
    {
        return [
            'height' => $this->getHeight()->toPixelsString(),
            'width' => $this->getWidth()->toPixelsString()
        ];
    }

    public function subtractHeight(Dimension $height)
    {
        $this->getHeight()->subtract($height);
    }
}