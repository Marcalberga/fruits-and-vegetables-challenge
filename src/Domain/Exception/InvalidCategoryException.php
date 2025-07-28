<?php

namespace App\Domain\Exception;

class InvalidCategoryException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Invalid Category for veggie", 400);
    }
}