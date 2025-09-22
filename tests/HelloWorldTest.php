<?php

declare(strict_types=1);

namespace Tests;

use App\HelloWorld;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    private HelloWorld $helloWorld;

    protected function setUp(): void
    {
        $this->helloWorld = new HelloWorld();
    }

    public function testSayHelloReturnsCorrectMessage(): void
    {
        $result = $this->helloWorld->sayHello();
        $this->assertEquals("Hello, World!", $result);
    }

    public function testRunOutputsHelloWorld(): void
    {
        $this->expectOutputString("Hello, World!" . PHP_EOL);
        $this->helloWorld->run();
    }
}