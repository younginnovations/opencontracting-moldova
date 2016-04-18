<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Contracts;

class ContractController extends Controller
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

    public function index()
    {
        return view('contracts.index');
    }

    public function show($contractor)
    {
        $contractor       = urldecode($contractor);
        $contractorDetail = $this->contracts->getDetailInfo($contractor, 'participant.fullName');
        $totalAmount      = $this->getTotalAmount($contractorDetail);
        $contractTrend    = $this->getTrend($this->contracts->aggregateContracts($contractorDetail));
        $amountTrend      = $this->contracts->encodeToJson($this->contracts->aggregateContracts($contractorDetail, 'amount'), 'trend');
        $procuringAgency  = $this->contracts->getProcuringAgency('amount', 5, $contractor, 'participant.fullName');
        $goodsAndServices = $this->contracts->getGoodsAndServices('amount', 5, $contractor, 'participant.fullName');

        return view('contracts.contractor-view', compact('contractor', 'contractorDetail', 'totalAmount', 'contractTrend', 'amountTrend', 'procuringAgency', 'goodsAndServices'));
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

    /**
     * @param $contractId
     * @return \Illuminate\View\View
     */
    public function view($contractId)
    {
        $contractDetail = $this->contracts->getContractDetailById($contractId);

        return view('contracts.view',compact('contractDetail'));
    }
}
