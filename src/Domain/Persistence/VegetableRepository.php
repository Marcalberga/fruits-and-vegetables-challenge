<?php

namespace App\Domain\Persistence;


use App\Domain\Model\Vegetable;

interface VegetableRepository
{
    public function add(Vegetable $fruit): void;
    public function remove(Vegetable $fruit): void;
    public function list(): array;
    public function get(int $id): ?Vegetable;

    public function search(array $criteria): array;
}