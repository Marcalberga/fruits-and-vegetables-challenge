<?php

namespace App\Domain\Model;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document]
class Fruit extends Veggie
{

}