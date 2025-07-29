<?php

namespace App\Application\Query\ListVeggies;

use App\Domain\Persistence\FruitRepository;
use App\Domain\Persistence\VegetableRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class ListVeggiesQueryHandler
{
    public function __construct(
        protected FruitRepository $fruitRepository,
        protected VegetableRepository $vegetableRepository)
    {}

    #[AsMessageHandler]
    public function __invoke(ListVeggiesQuery $listVeggiesQuery): array
    {
        $filters = $listVeggiesQuery->filters;

        $result = [];

        // TODO: add filter usage
        if(!isset($filters['type']) or $filters['type'] == 'fruit'){
            $result['fruits'] = $this->fruitRepository->list();
        }
        if(!isset($filters['type']) or $filters['type'] == 'vegetable') {
            $result['vegetables'] = $this->vegetableRepository->list();
        }

        return $result;
    }
}