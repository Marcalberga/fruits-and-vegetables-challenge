<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Fruit;
use App\Domain\Persistence\FruitRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\Regex;

class FruitDoctrineMongoRepository implements FruitRepository
{
    public function __construct(protected DocumentManager $dm) {}

    public function add(Fruit $fruit): void
    {
        $this->dm->persist($fruit);
        $this->dm->flush();
    }

    public function remove(Fruit $fruit): void
    {
        $this->dm->remove($fruit);
        $this->dm->flush();
    }

    public function list(): array
    {
        $qb = $this->dm->createQueryBuilder(Fruit::class);
        $result = $qb
            ->getQuery()
            ->execute();
        return $result->toArray();
    }

    public function get(int $id): ?Fruit
    {
        $qb = $this->dm->createQueryBuilder(Fruit::class);
        return $qb->field('id')
            ->equals($id)
            ->getQuery()
            ->getSingleResult();
    }

    public function search(array $criteria): array
    {
        if (!empty($criteria['type']) && $criteria['type'] !== 'fruit') {
            return [];
        }

        $qb = $this->dm->createQueryBuilder(Fruit::class);
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