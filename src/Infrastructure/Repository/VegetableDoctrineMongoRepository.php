<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Vegetable;
use App\Domain\Persistence\VegetableRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\Regex;

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

    public function get(int $id): ?Vegetable
    {
        $qb = $this->dm->createQueryBuilder(Vegetable::class);
        return $qb->field('id')
        ->equals($id)
        ->getQuery()
        ->getSingleResult();
    }
    public function search(array $criteria): array
    {
        if (!empty($criteria['type']) && $criteria['type'] !== 'vegetable') {
            return [];
        }

        $qb = $this->dm->createQueryBuilder(Vegetable::class);
        if (!empty($criteria['name'])) {
            $qb->field('name')->equals(new Regex($criteria['name'], "i"));
        }
        if (!empty($criteria['minQuantity'])) {
            $qb->field('quantity')->gte( (int) $criteria['minQuantity']);
        }
        if (!empty($criteria['maxQuantity'])) {
            $qb->field('quantity')->lte( (int) $criteria['maxQuantity']);
        }

        return $qb->getQuery()
            ->execute()
            ->toArray();
    }
}