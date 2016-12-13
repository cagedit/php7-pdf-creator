<?php
namespace File;

class FileList implements FileListInterface
{
    private $list;

    public function getList(): array
    {
        return $this->list ?? [];
    }

    public function add(string $file): FileListInterface
    {
        $this->list[] = $file;
        return $this;
    }

    public function addMany(array $files): FileListInterface
    {
        $list = $this->getList();

        $this->list = array_merge($list, $files);

        return $this;
    }

    public function first(): string
    {
        return current($this->getList()) ?? '';
    }
}