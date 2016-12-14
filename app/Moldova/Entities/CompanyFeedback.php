<?php namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CompanyFeedback extends Eloquent
{
    protected $collection = "company_feedback_collection";

    public $fillable = [
        "date_of_document",
        "number_di",
        "ac_challenge",
        "issuer",
        "under_appeal",
        "procedure_no",
        "oa",
        "content_agency_decision",
        "clear_name"
    ];
}