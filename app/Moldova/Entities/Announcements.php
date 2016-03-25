<?php

namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Announcements extends Eloquent
{
    protected $collection = "announcements_collection";

}
