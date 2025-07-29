<?php

namespace App\Infrastructure\http\Controller;

use App\Application\Query\ListVeggies\ListVeggiesQuery;
use App\Infrastructure\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListVeggiesController extends AbstractController
{
    #[Route(
        '/api/veggies',
        name: 'list_veggies',
        methods: ['GET'])]
    public function __invoke(Request $request, QueryBus $queryBus): Response
    {
        $params = $request->query->all();

        $result = $queryBus->ask(new ListVeggiesQuery($params));

        return new JsonResponse($result);
    }
}