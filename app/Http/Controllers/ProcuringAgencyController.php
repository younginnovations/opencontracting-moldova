<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Contracts;
use App\Moldova\Service\Tenders;

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
     * ContractController constructor.
     * @param Contracts $contracts
     * @param Tenders   $tenders
     */
    public function __construct(Contracts $contracts, Tenders $tenders)
    {
        $this->contracts = $contracts;
        $this->tenders   = $tenders;
    }

    public function show($procuringAgency)
    {
        $procuringAgency       = urldecode($procuringAgency);
        $procuringAgencyDetail = $this->contracts->getDetailInfo($procuringAgency, "tender.stateOrg.orgName");
        $totalAmount           = $this->getTotalAmount($procuringAgencyDetail);
        $tenderTrends          = $this->tenders->getProcuringAgencyTenderByOpenYear($procuringAgency);
        $trends                = $this->mergeContractAndTenderTrends($tenderTrends, $this->contracts->aggregateContracts($procuringAgencyDetail));
        $amountTrend           = $this->contracts->encodeToJson($this->contracts->aggregateContracts($procuringAgencyDetail, 'amount'), 'trend');
        $contractors           = $this->contracts->getContractors('amount', 5, $procuringAgency, "tender.stateOrg.orgName");
        $goodsAndServices      = $this->contracts->getGoodsAndServices('amount', 5, $procuringAgency, "tender.stateOrg.orgName");

        return view('procuring-agency-detail', compact('procuringAgency', 'procuringAgencyDetail', 'totalAmount', 'trends', 'amountTrend', 'contractors', 'goodsAndServices'));
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
