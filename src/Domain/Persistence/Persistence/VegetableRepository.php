<?php

namespace App\Domain\Persistence\Persistence;

use App\Domain\Model\Vegetable;

interface VegetableRepository
{
    public function add(Vegetable $fruit): int;
    public function remove(Vegetable $fruit): void;
    public function list(): array;
}