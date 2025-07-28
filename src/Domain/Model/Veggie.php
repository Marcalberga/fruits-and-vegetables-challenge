<?php

namespace App\Domain\Model;

abstract class Veggie
{
    protected function __construct(
        public int $id,
        public string $name,
        public int $quantity
    ){}

    public static function createFromArray(array $data): self
    {
        // TODO: Move units to ENUM for scalability
        return new static(
            $data['id'],
            $data['name'],
            $data['unit'] == "g" ? $data['quantity'] : $data['quantity'] * 1000,
        );
    }
}