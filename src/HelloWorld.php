<?php

declare(strict_types=1);

namespace App;

class HelloWorld
{
    public function sayHello(): string
    {
        return "Hello, World!";
    }

    public function run(): void
    {
        echo $this->sayHello() . PHP_EOL;
    }
}