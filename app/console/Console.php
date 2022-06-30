<?php
namespace App\Console;

abstract class Console {
    public function __construct(private array $input)
    {
        
    }

    protected function getInput() {
        return $this->input;
    }
}