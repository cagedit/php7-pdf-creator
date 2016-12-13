<?php
namespace Writer;

use Exception;
use File\FileList;
use File\File;
use Page\Formats\FormatInterface;
use Script\CommandLineScriptEntity;

class PdfWriter implements WriterInterface
{
    /** @var string */
    private $directory;

    /** @var FileList */
    private $htmlFiles;

    /** @var FileList */
    private $pdfFiles;

    /** @var FormatInterface */
    private $format;

    public function __construct()
    {
        $this->pdfFiles  = new FileList;
        $this->htmlFiles = new FileList;
    }

    public function write(string $data)
    {
        $file = $this->getNewFilename() . '.html';
        if (File::write($file, $data) === false) {
            throw new Exception("Could not write file at: {$file}.");
        }

        $this->htmlFiles->add($file);

        return $this;
    }

    public function persist()
    {
        $this->writeJs();
        $this->runPhantom();

        $this->pdfFiles->addMany(glob($this->getDirectory('*.pdf')) ?? []);

        return $this->pdfFiles;
    }

    private function writeJs()
    {
        $filename = $this->getDirectory('script.js');

        $files = $this->htmlFiles->getList();

        $script = File::read(rootDir('script.js'));

        foreach ($files as $file) {
            $script .= " phantomjs.addDocument('{$file}');";
        }

        $script .= "phantomjs.setPaperSize({$this->getPaperSize()}); phantomjs.print();";
        $script .= "phantomjs.setViewportSize({$this->getViewportSize()});";

        File::write($filename, $script);
    }

    private function runPhantom()
    {
        $filename = $this->getDirectory('script.js');

        return (new CommandLineScriptEntity)
            ->setCommand('phantomjs')
//            ->addArg('remote-debugger-port', 9000)
            ->addString($filename)
            ->execute();
    }

    public function getDirectory(string $suffix = '')
    {
        return $this->directory . '/' . $suffix;
    }

    public function setDirectory(string $directory)
    {
        $this->directory = $directory . '/' . uniqid();

        if (!mkdir($this->getDirectory(), 0777, true)) {
            throw new Exception("Unable to create the directory: {$directory}");
        }

        chmod($this->directory, 0777);

        return $this;
    }

    private function getNewFilename()
    {
        return $this->getDirectory() . uniqid();
    }

    public function setFormat(FormatInterface $format): WriterInterface
    {
        $this->format = $format;
        return $this;
    }

    public function getFormat(): FormatInterface
    {
        return $this->format;
    }

    private function getPaperSize(): string
    {
        return json_encode($this->getFormat()->getPaperSizeArray());
    }

    private function getViewportSize(): string
    {
        $format = $this->getFormat();
        return json_encode(['height' => $format->getHeight()->getDimension(), 'width' => $format->getWidth()->getDimension()]);
    }
}