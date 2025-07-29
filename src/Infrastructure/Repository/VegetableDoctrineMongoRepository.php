<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Vegetable;
use App\Domain\Persistence\VegetableRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class VegetableDoctrineMongoRepository implements VegetableRepository
{
    public function __construct(protected DocumentManager $dm) {}

    public function add(Vegetable $vegetable): void
    {
        $this->dm->persist($vegetable);
        $this->dm->flush();
    }

    public function remove(Vegetable $vegetable): void
    {
        $this->dm->remove($vegetable);
        $this->dm->flush();
    }

    public function list(): array
    {
        $qb = $this->dm->createQueryBuilder(Vegetable::class);
        $result = $qb
            ->getQuery()
            ->execute();
        return $result->toArray();
    }
}