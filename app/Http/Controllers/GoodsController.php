<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;


class GoodsController extends Controller
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
        return view('goods-index');
    }


    /**
     * @param $goods
     * @return \Illuminate\View\View
     */
    public function show($goods)
    {
        $goods           = urldecode($goods);
        $goodsDetail     = $this->contracts->getDetailInfo($goods, "goods.mdValue");
        $totalAmount     = $this->getTotalAmount($goodsDetail);
        $contractTrend   = $this->getTrend($this->contracts->aggregateContracts($goodsDetail));
        $amountTrend     = $this->contracts->encodeToJson($this->contracts->aggregateContracts($goodsDetail, 'amount'), 'trend');
        $contractors     = $this->contracts->getContractors('amount', 5, $goods, "goods.mdValue");
        $procuringAgency = $this->contracts->getProcuringAgency('amount', 5, $goods, 'goods.mdValue');

        return view('goods-detail', compact('goods', 'goodsDetail', 'totalAmount', 'contractTrend', 'amountTrend', 'contractors', 'procuringAgency'));
    }

    /**
     * @param $contracts
     * @return int
     */
    private function getTotalAmount($contracts)
    {
        $total = 0;

        foreach ($contracts as $key => $contract) {
            $total += $contract['amount'];
        }

        return ($total);
    }

    /**
     * @param $contracts
     * @return string
     */
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
