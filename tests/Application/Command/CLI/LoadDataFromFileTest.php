<?php

namespace App\Tests\Application\Command\CLI;

use App\Application\Command\CLI\LoadDataFromFile;
use App\Domain\Model\Fruit;
use App\Domain\Model\Vegetable;
use App\Domain\Persistence\FruitRepository;
use App\Domain\Persistence\VegetableRepository;
use PHPUnit\Framework\TestCase;

class LoadDataFromFileTest extends TestCase
{
    public function testCanLoadAFileCorrectly()
    {
        $fruitRepositoryMock = $this->createMock( FruitRepository::class);
        $fruitRepositoryMock->expects($this->exactly(2))
            ->method('add')
            ->with($this->isInstanceOf(Fruit::class));

        $vegetableRepositoryMock = $this->createMock( VegetableRepository::class);
        $vegetableRepositoryMock->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf(Vegetable::class));

        $stub = new class($fruitRepositoryMock, $vegetableRepositoryMock) extends LoadDataFromFile {
            protected function loadFile(string $path): array
            {
                return [
                    [
                        "id" => 1,
                        "name" => "Carrot",
                        "type" => "vegetable",
                        "quantity" => 10922,
                        "unit" => "g"
                    ],
                    [
                        "id" => 2,
                        "name" => "Apples",
                        "type" => "fruit",
                        "quantity" => 20,
                        "unit" => "kg"
                    ],
                    [
                        "id" => 3,
                        "name" => "Pears",
                        "type" => "fruit",
                        "quantity" => 3500,
                        "unit" => "g"
                    ]
                ];
            }
        };

        $stub->execute("test/path");
    }
}
