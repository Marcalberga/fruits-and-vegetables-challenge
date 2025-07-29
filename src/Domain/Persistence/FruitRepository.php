<?php

namespace App\Domain\Persistence;

use App\Domain\Model\Fruit;

interface FruitRepository
{
    public function add(Fruit $fruit): void;
    public function remove(Fruit $fruit): void;
    public function list(): array;
}