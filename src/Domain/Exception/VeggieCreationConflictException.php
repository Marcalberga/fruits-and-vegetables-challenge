<?php

namespace App\Domain\Exception;

class VeggieCreationConflictException extends \Exception
{
    public function __construct(
        string $message = "Veggie with same ID already exists",
        int $code = 409,
        ?\Throwable $previous = null
    ){
        parent::__construct($message, $code, $previous);
    }
}