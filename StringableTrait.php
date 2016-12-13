<?php
trait StringableTrait
{
    public function __toString(): string
    {
        $string = '';
        foreach ($this->getItems() as $item) {
            $string .= is_string($item) ? $item : $item->__toString();
        }

        if (method_exists($this, 'finalize')) {
            $string = $this->finalize($string);
        }

        return $string;
    }
}