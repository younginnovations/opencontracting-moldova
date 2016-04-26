<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Contracts;
use App\Moldova\Service\ProcuringAgency;
use App\Moldova\Service\Tenders;
use Illuminate\Http\Request;

class ProcuringAgencyController extends Controller
{
    /**
     * @var Contracts
     */
    private $contracts;
    /**
     * @var Tenders
     */
    private $tenders;
    /**
     * @var ProcuringAgency
     */
    private $procuringAgency;

    /**
     * ContractController constructor.
     * @param Contracts       $contracts
     * @param Tenders         $tenders
     * @param ProcuringAgency $procuringAgency
     */
    public function __construct(Contracts $contracts, Tenders $tenders, ProcuringAgency $procuringAgency)
    {
        $this->contracts       = $contracts;
        $this->tenders         = $tenders;
        $this->procuringAgency = $procuringAgency;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $procuringAgency = $this->contracts->getProcuringAgency('amount', 5);

        return view('agency.index', compact('procuringAgency'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProcuringAgency(Request $request)
    {
        $input = $request->all();

        return $this->procuringAgency->getAllProcuringAgency($input);
    }

    public function show($procuringAgency)
    {
        $procuringAgency       = urldecode($procuringAgency);
        $agencyData            = $this->procuringAgency->getAgencyData($procuringAgency);
        //dd($agencyData->buyer['contactPoint']);
        $procuringAgencyDetail = $this->contracts->getDetailInfo($procuringAgency, "tender.stateOrg.orgName");
        $totalAmount           = $this->getTotalAmount($procuringAgencyDetail);
        $tenderTrends          = $this->tenders->getProcuringAgencyTenderByOpenYear($procuringAgency);
        $trends                = $this->mergeContractAndTenderTrends($tenderTrends, $this->contracts->aggregateContracts($procuringAgencyDetail));
        $amountTrend           = $this->contracts->encodeToJson($this->contracts->aggregateContracts($procuringAgencyDetail, 'amount'), 'trend');
        $contractors           = $this->contracts->getContractors('amount', 5, $procuringAgency, "tender.stateOrg.orgName");
        $goodsAndServices      = $this->contracts->getGoodsAndServices('amount', 5, $procuringAgency, "tender.stateOrg.orgName");

        return view(
            'agency.view',
            compact('agencyData', 'procuringAgency', 'procuringAgencyDetail', 'totalAmount', 'trends', 'amountTrend', 'contractors', 'goodsAndServices')
        );
    }

    private function getTotalAmount($contracts)
    {
        $total = 0;

        foreach ($contracts as $key => $contract) {
            $total += $contract['amount'];
        }

        return ($total);
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
