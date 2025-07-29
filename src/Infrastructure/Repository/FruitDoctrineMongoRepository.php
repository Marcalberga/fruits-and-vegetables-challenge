<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Fruit;
use App\Domain\Persistence\FruitRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

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
        $result = $qb->select('f')
            ->getQuery()
            ->execute();
        $varToStopDebugger = true;
    }


}