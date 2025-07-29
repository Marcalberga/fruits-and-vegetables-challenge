<?php

namespace App\Domain\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;


/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "fruit"=App\Domain\Model\Fruit::class,
 *     "vegetable"=App\Domain\Model\Vegetable::class
 * })
 */
abstract class Veggie
{
    #[ODM\Id(type: "integer", strategy: "NONE")]
    public int $id;
    #[ODM\Field(type: "string")]
    public string $name;
    #[ODM\Field(type: "integer")]
    public int $quantity;

    public function __construct(
        $id,
        $name,
        $quantity
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