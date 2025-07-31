<?php

namespace App\Application\Command\CLI;

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

    protected function loadFile(string $path): array
    {
        /* TODO: Load JSON securely and double checking origin and contents before any action */
        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    public function execute(string $path): void
    {

        $data = $this->loadFile($path);
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