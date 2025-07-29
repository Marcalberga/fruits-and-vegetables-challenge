<?php

namespace App\Application\Query\ListVeggies;

use App\Domain\Model\Veggie;

class ListVeggiesQuery
{
    public function __construct(public array $filters){}
}