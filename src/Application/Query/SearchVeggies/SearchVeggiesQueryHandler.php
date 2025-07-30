<?php

namespace App\Application\Query\SearchVeggies;

use App\Domain\Persistence\FruitRepository;
use App\Domain\Persistence\VegetableRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class SearchVeggiesQueryHandler
{
    public function __construct(
        protected FruitRepository $fruitRepository,
        protected VegetableRepository $vegetableRepository
    ){}

    #[AsMessageHandler]
    public function __invoke(SearchVeggiesQuery $query)
    {
        $params = $query->filters;

        return [
            'fruits' => $this->fruitRepository->search($params),
            'vegetables' => $this->vegetableRepository->search($params),
        ];
    }
}