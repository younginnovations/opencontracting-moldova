<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Contracts;

class ProcuringAgencyController extends Controller
{
    /**
     * @var Contracts
     */
    private $contracts;

    /**
     * ContractController constructor.
     * @param Contracts $contracts
     */
    public function __construct(Contracts $contracts)
    {
        $this->contracts = $contracts;
    }

    public function show($procuringAgency)
    {
        $procuringAgency       = urldecode($procuringAgency);
        $procuringAgencyDetail = $this->contracts->getDetailInfo($procuringAgency, "tender.stateOrg.orgName");
        $totalAmount           = $this->getTotalAmount($procuringAgencyDetail);
        $contractTrend         = $this->getTrend($this->contracts->aggregateContracts($procuringAgencyDetail));
        $amountTrend           = $this->contracts->encodeToJson($this->contracts->aggregateContracts($procuringAgencyDetail, 'amount'), 'trend');
        $contractors           = $this->contracts->getContractors('amount', 5, $procuringAgency, "tender.stateOrg.orgName");
        $goodsAndServices      = $this->contracts->getGoodsAndServices('amount', 5, $procuringAgency, "tender.stateOrg.orgName");

        return view('procuring-agency-detail', compact('procuringAgency', 'procuringAgencyDetail', 'totalAmount', 'contractTrend', 'amountTrend', 'contractors', 'goodsAndServices'));
    }

    private function getTotalAmount($contracts)
    {
        $total = 0;

        foreach ($contracts as $key => $contract) {
            $total += $contract['amount'];
        }

        return ($total);
    }

    private function getTrend($contracts)
    {
        $trends = [];
        $count  = 0;
        ksort($contracts);

        foreach ($contracts as $key => $contract) {
            $trends[$count]['xValue'] = $key;
            $trends[$count]['chart1'] = 0;
            $trends[$count]['chart2'] = $contract;
            $count ++;
        }

        return json_encode($trends);
    }
}
