<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Tenders;

class TenderController
{
    /**
     * @var Tenders
     */
    private $tenders;

    public function __construct(Tenders $tenders)
    {

        $this->tenders = $tenders;
    }

    public function index()
    {
        $tenders = $this->tenders->getAllTenders();

        return view('tender-index', compact('tenders'));
    }


    /**
     * @param $tenderID
     * @return \Illuminate\View\View
     */
    public function show($tenderID)
    {
        $tenderDetail = $this->tenders->getTenderDetailByID($tenderID);

        return view('tender-view', compact('tenderDetail'));

    }

}
