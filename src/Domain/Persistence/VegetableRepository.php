<?php

namespace App\Domain\Persistence;

use App\Domain\Model\Vegetable;

interface VegetableRepository
{
    public function add(Vegetable $fruit): void;
    public function remove(Vegetable $fruit): void;
    public function list(): array;
}