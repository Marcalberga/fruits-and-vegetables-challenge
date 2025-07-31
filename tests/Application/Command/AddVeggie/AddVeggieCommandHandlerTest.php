<?php

namespace App\Tests\Application\Command\AddVeggie;

use App\Application\Command\AddVeggie\AddVeggieCommand;
use App\Application\Command\AddVeggie\AddVeggieCommandHandler;
use App\Domain\Model\Fruit;
use App\Domain\Model\Vegetable;
use App\Domain\Model\VeggieFactory;
use App\Domain\Persistence\FruitRepository;
use App\Domain\Persistence\VegetableRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AddVeggieCommandHandlerTest extends TestCase
{

    #[DataProvider('veggieDataProvider')]
    public function testCanCreateVegetables(array $data): void
    {

        $command = new AddVeggieCommand($data);

        $fruitRepositoryMock = $this->createMock( FruitRepository::class);
        $fruitRepositoryMock->expects($data['type'] === "fruit" ? $this->once(): $this->never())
            ->method('get')
            ->willReturn(null);
        $fruitRepositoryMock->expects($data['type'] === "fruit" ? $this->once(): $this->never())
            ->method('add')
            ->with($this->isInstanceOf(Fruit::class));

        $vegetableRepositoryMock = $this->createMock( VegetableRepository::class);
        $vegetableRepositoryMock->expects($data['type'] === "vegetable" ? $this->once(): $this->never())
            ->method('get')
            ->willReturn(null);
        $vegetableRepositoryMock->expects($data['type'] === "vegetable" ? $this->once(): $this->never())
            ->method('add')
            ->with($this->isInstanceOf(Vegetable::class));

        $veggieUnderTest = VeggieFactory::createVeggie($data);

        $handler = new AddVeggieCommandHandler($fruitRepositoryMock, $vegetableRepositoryMock);

        $result = $handler->__invoke($command);
        $this->assertEquals($result, $veggieUnderTest);
    }

    public static function veggieDataProvider(): array {
        $melon = [
            "id" => 4,
            "name" => "Melons",
            "type" => "fruit",
            "quantity" => 120,
            "unit" => "kg"
        ];
        $beans = [
            "id" => 5,
            "name" => "Beans",
            "type" => "vegetable",
            "quantity" => 65000,
            "unit" => "g"
        ];

        return [
            [$melon],
            [$beans]
        ];
    }
}
