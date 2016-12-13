<?php
namespace Presenters;

use File\File;

class InlinePdfPresenter extends AbstractPresenter
{
    private $content;

    public function readPdfFile(string $file): AbstractPresenter
    {
        $this->setContent(File::read($file));
        return $this;
    }

    public function setContent(string $content): AbstractPresenter
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content ?? '';
    }

    protected function setHeaders(): AbstractPresenter
    {
        $headers = [
            'content-type' => 'application/pdf',
            'Cache-control' => 'private',
            'Content-Disposition' => 'inline',
            'filename' => uniqid() . '.pdf'
        ];

        foreach ($headers as $prop => $value) {
            header("{$prop}: {$value}", true);
        }

        return $this;
    }
}