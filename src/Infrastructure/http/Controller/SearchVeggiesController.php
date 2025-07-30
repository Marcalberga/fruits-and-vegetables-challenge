<?php

namespace App\Infrastructure\http\Controller;

use App\Application\Query\SearchVeggies\SearchVeggiesQuery;
use App\Infrastructure\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchVeggiesController extends AbstractController
{
    #[Route(
        '/api/search',
        name: 'search_veggies',
        methods: ['GET'])]
    public function __invoke(Request $request, QueryBus $queryBus): Response
    {
        $params = $request->query->all();

        $result = $queryBus->ask(new SearchVeggiesQuery($params));

        return new JsonResponse($result);
    }
}