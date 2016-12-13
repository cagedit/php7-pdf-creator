<?php
namespace Page\Formats;

class Dimension
{
    private $dpi = 120;
    private $dimension;
    private $unit;

    public function __construct($dimension, $unit)
    {
        $this->setDimension($dimension);
        $this->setUnit($unit);
    }

    public function getDpi()
    {
        return $this->dpi;
    }

    public function setDimension(int $dimension): Dimension
    {
        $this->dimension = $dimension;
        return $this;
    }

    public function getDimension()
    {
        return $this->dimension;
    }

    public function setUnit(string $unit): Dimension
    {
        $this->unit = $unit;
        return $this;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function getPixels()
    {
        switch ($this->getUnit()) {
            case 'in':
                $pixels = $this->getDimension() * $this->getDpi();
                break;
            case 'px':
            default:
                $pixels = $this->getDimension();
                break;
        }
        return $pixels;
    }

    public function toString()
    {
        return (string) $this->getDimension() . $this->getUnit();
    }

    public function toPixelsString()
    {
        return $this->getPixels() . 'px';
    }

    public function subtract(Dimension $subAmount)
    {
        $this->setDimension($this->getPixels() - $subAmount->getPixels());
        $this->setUnit('px');
    }
}