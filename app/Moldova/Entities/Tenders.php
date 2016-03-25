<?php

namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Tenders extends Eloquent
{
    protected $collection = "tenders_collection";
}
