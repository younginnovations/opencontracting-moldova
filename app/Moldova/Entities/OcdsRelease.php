<?php

namespace App\Moldova\Entities;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OcdsRelease extends Eloquent
{
    protected $collection = "ocds_release";

}
