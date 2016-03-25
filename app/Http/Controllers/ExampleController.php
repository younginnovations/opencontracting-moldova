<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Tenders;

class ExampleController extends Controller
{

    /**
     * ExampleController constructor.
     * @param Tenders $tenders
     */
    public function __construct(Tenders $tenders)
    {
        $this->tenders = $tenders;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(Contracts $contracts)
    {
        $tenders = $this->tenders->getTendersByOpenYear();
        $contracts = $contracts->getContractsByOpenYear();

        return view('app', compact('tenders','contracts'));
    }
}
