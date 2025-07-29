<?php

namespace App\Infrastructure\http\Controller;

use App\Application\Query\ListVeggies\ListVeggiesQuery;
use App\Infrastructure\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListVegetablesController extends AbstractController
{
    #[Route(
        '/api/vegetables',
        name: 'list_vegetables',
        methods: ['GET'])]
    public function __invoke(Request $request, QueryBus $queryBus): Response
    {
        $params = ["type" => "vegetable"];

        $result = $queryBus->ask(new ListVeggiesQuery($params));

        return new JsonResponse($result);
    }
}