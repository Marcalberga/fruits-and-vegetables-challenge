<?php

namespace App\Application\Command;

use App\Domain\Exception\InvalidCategoryException;
use App\Domain\Model\Fruit;
use App\Domain\Model\Vegetable;
use App\Domain\Model\Veggie;
use App\Domain\Model\VeggieFactory;
use App\Domain\Persistence\FruitRepository;
use App\Domain\Persistence\VegetableRepository;

class LoadDataFromFile
{

    public function __construct(
        protected FruitRepository $fruitRepository,
        protected VegetableRepository $vegetableRepository)
    {}

    public function execute(string $path): void {
        /* TODO: Load JSON securely and double checking origin and contents before any action */
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        foreach ($data as $veggieData) {
            // do stuff
            try {
                $model = VeggieFactory::createVeggie($veggieData);
            } Catch(InvalidCategoryException $e) {
                print($e->getMessage());
                continue;
            }
            $repository = $this->getRepositoryForClass($model);
            $repository->add($model);
            // store to database
        }

    }

    private function getRepositoryForClass(Veggie $model): VegetableRepository|FruitRepository
    {
        return match(get_class($model)) {
            Fruit::class => $this->fruitRepository,
            Vegetable::class => $this->vegetableRepository,
        };
    }
}