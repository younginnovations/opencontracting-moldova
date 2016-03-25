<?php

namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Contracts extends Eloquent
{
    protected $collection = "contracts_collection";
}
