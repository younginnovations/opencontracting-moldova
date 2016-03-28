<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Tenders;

class HomeController extends Controller
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
     * @param Contracts $contracts
     * @return \Illuminate\View\View
     */
    public function index(Contracts $contracts)
    {
        $totalContractAmount = round($contracts->getTotalContractAmount());
        $tendersTrends       = $this->tenders->getTendersByOpenYear();
        $contractsTrends     = $contracts->getContractsByOpenYear();
        $trends              = $this->mergeContractAndTenderTrends($tendersTrends, $contractsTrends);
        $procuringAgency     = $contracts->getProcuringAgency('amount', 5);
        $contractors         = $contracts->getContractors('amount', 5);
        $goodsAndServices    = $contracts->getGoodsAndServices('amount', 5);
        $contractsList       = $contracts->getContractsList(10);

        return view('index', compact('totalContractAmount', 'trends', 'procuringAgency', 'contractors', 'goodsAndServices', 'contractsList'));
    }

    protected function mergeContractAndTenderTrends($tendersTrends, $contractsTrends)
    {
        $trends = [];
        $count  = 0;

        foreach ($tendersTrends as $key => $tender) {
            $trends[$count]['xValue'] = $key;
            $trends[$count]['chart1'] = $tender;
            $trends[$count]['chart2'] = $contractsTrends[$key];
            $count ++;
        }

        return json_encode($trends);
    }
}
