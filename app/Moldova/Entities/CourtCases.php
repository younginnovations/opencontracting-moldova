<?php namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CourtCases extends Eloquent
{
    protected $collection = "court_cases_collection";

    protected $fillable = [
        "id",
        "case_type",
        "case_number",
        "title",
        "court_name",
        "theme",
        "delivery_date",
        "link",
        "clear_name"
    ];
}