<?php
namespace File;

interface FileListInterface
{
    public function add(string $file): FileListInterface;
    public function addMany(array $files): FileListInterface;
    public function first(): string;
}