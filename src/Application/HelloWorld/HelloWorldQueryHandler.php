<?php

namespace App\Application\HelloWorld;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class HelloWorldQueryHandler
{
    public function __invoke(HelloWorldQuery $helloWorldQuery)
    {
        return "Hello World!";
    }
}