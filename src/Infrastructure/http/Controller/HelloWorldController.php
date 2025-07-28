<?php

namespace App\Infrastructure\http\Controller;

use App\Application\HelloWorld\HelloWorldQuery;
use App\Infrastructure\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/', name: 'HelloWorld', methods: ['GET'])]
    public function __invoke(Request $request, QueryBus $bus): JsonResponse
    {
        $result = $bus->ask(new HelloWorldQuery());
        return new JsonResponse($result);
    }
}