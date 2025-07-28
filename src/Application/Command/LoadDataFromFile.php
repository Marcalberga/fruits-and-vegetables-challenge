<?php

namespace App\Application\Command;

use App\Domain\Model\Veggie;
use App\Domain\Model\VeggieFactory;

class LoadDataFromFile
{
    public function __construct()
    {

    }

    public function execute(string $path): void {
        /* TODO: Load JSON securely and double checking origin and contents before any action */
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        foreach ($data as $veggie) {
            // do stuff
            $model = VeggieFactory::createVeggie($veggie);
            print("$model->name : " . get_class($model) . " : $model->quantity\n");
        }

    }
}