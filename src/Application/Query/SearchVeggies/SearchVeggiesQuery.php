<?php

namespace App\Application\Query\SearchVeggies;

class SearchVeggiesQuery
{
    public function __construct(public array $filters){}
}