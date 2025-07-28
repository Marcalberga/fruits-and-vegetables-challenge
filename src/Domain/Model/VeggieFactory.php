<?php

namespace App\Domain\Model;

use App\Domain\Exception\InvalidCategoryException;

class VeggieFactory
{
    public static function createVeggie(array $data): Veggie
    {
        // TODO: Move the type to ENUM instead of hardcoded string
        return match($data['type']) {
            "fruit" => Fruit::createFromArray($data),
            "vegetable" => Vegetable::createFromArray($data),
            default => throw new InvalidCategoryException(),
        };
    }
}