<?php

namespace App\Infrastructure\http\Controller;

use App\Application\Command\AddVeggie\AddVeggieCommand;
use App\Infrastructure\CQRS\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddVeggieController extends AbstractController
{
    #[Route(
        '/api/veggies',
        name: 'add_veggie',
        methods: ['POST'])]
    public function __invoke(Request $request, CommandBus $commandBus): Response
    {
        $body = json_decode($request->getContent(), true);
        $result = $commandBus->execute(new AddVeggieCommand($body));

        return new JsonResponse($result);
    }
}