<?php

namespace App\Moldova\Entities;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Contracts extends Eloquent
{
    protected $collection = "contracts_collection";

//    protected $dates = ['finalDate', 'contractDate'];
}
