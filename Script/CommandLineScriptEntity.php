<?php
namespace Script;

class CommandLineScriptEntity
{
    private $args;

    public function addArg($arg, $value): CommandLineScriptEntity
    {
        $this->args[$arg] = $value;
        return $this;
    }

    public function getArgs(): array
    {
        return $this->args ?? [];
    }

    public function setCommand($command): CommandLineScriptEntity
    {
        $this->command = $command;
        return $this;
    }

    public function getCommand()
    {
        return $this->command ?? '';
    }

    public function addString(string $string): CommandLineScriptEntity
    {
        $this->strings[] = $string;
        return $this;
    }

    public function getStrings(): array
    {
        return $this->strings ?? [];
    }

    public function execute()
    {
        exec($this);
    }

    public function __toString(): string
    {
        $string = $this->getCommand();
        foreach ($this->getArgs() as $arg => $value) {
            $string .= " --{$arg}=\"{$value}\"";
        }

        $strings = implode(' ', $this->getStrings());

        $string .= " {$strings}";

        return $string;
    }
}