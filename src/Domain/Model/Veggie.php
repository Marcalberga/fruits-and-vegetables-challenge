<?php

namespace App\Domain\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

abstract class Veggie
{
    #[Id(type: "integer", strategy: "NONE")]
    public int $id;
    #[Field]
    public string $name;
    #[Field]
    public int $quantity;

    protected function __construct(
        int $id,
        string $name,
        int $quantity
    ){
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
    }

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