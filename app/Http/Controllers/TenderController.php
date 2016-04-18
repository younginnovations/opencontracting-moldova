<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Tenders;
use Illuminate\Http\Request;

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

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('tender.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTenders(Request $request)
    {
        $input = $request->all();

        return $this->tenders->getAllTenders($input);
    }


    /**
     * @param $tenderID
     * @return \Illuminate\View\View
     */
    public function show($tenderID)
    {
        $tenderDetail = $this->tenders->getTenderDetailByID($tenderID);

        return view('tender.view', compact('tenderDetail'));

    }

}
