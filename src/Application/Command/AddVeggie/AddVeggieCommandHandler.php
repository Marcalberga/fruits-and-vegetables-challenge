<?php

namespace App\Application\Command\AddVeggie;

use App\Domain\Exception\VeggieCreationConflictException;
use App\Domain\Model\Fruit;
use App\Domain\Model\Vegetable;
use App\Domain\Model\Veggie;
use App\Domain\Model\VeggieFactory;
use App\Domain\Persistence\FruitRepository;
use App\Domain\Persistence\VegetableRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class AddVeggieCommandHandler
{
    public function __construct(
        protected FruitRepository $fruitRepository,
        protected VegetableRepository $vegetableRepository
    ){}

    #[AsMessageHandler]
    public function __invoke(AddVeggieCommand $command): Veggie
    {
        $vegetable = VeggieFactory::createVeggie($command->data);
        /** @var FruitRepository|VegetableRepository $repository */
        $repository = match(get_class($vegetable)) {
            Vegetable::class => $this->vegetableRepository,
            Fruit::class => $this->fruitRepository,
        };

        $existingVeggie = $repository->get($vegetable->id);

        if ($existingVeggie && $existingVeggie->name !== $vegetable->name) {
            throw new VeggieCreationConflictException();
        }

        $repository->add($vegetable);

        return $vegetable;
    }
}