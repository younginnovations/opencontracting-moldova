<?php namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Blacklist extends Eloquent
{
    protected $collection = "blacklist_collection";

//    public $fillable = ["organizationName", "address", "description", "decisionDate", "deadlineDate", "mentions","clear_name"];
    public $fillable = ["address", "decisionDate", "deadlineDate", "mentions", "description", "organizationName","clear_name"];

}
