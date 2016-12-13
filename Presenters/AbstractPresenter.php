<?php
namespace Presenters;

abstract class AbstractPresenter
{
    abstract public function setContent(string $content): AbstractPresenter;
    abstract public function getContent(): string;

    public function __toString(): string
    {
        $this->setHeaders();
        return $this->getContent();
    }

    protected function setHeaders(): AbstractPresenter
    {
        return $this;
    }
}