<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Goods;
use App\Moldova\Service\StreamExporter;
use Illuminate\Http\Request;


class GoodsController extends Controller
{
    /**
     * @var Contracts
     */
    private $contracts;
    /**
     * @var Goods
     */
    private $goods;
    /**
     * @var StreamExporter
     */
    private $exporter;

    /**
     * ContractController constructor.
     *
     * @param Contracts      $contracts
     * @param Goods          $goods
     * @param StreamExporter $exporter
     */
    public function __construct(Contracts $contracts, Goods $goods, StreamExporter $exporter)
    {
        $this->contracts = $contracts;
        $this->goods     = $goods;
        $this->exporter  = $exporter;
    }

    public function index()
    {
        $goodsAndServices = $this->contracts->getGoodsAndServices('amount', 5, ['from' => date('Y'), 'to' => date('Y')]);
        $totalGoods       = $this->goods->getGoodsCount("");

        return view('goods.index', compact('goodsAndServices', 'totalGoods'));
    }

    /**
     * Fetch all Goods
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getAllGoods(Request $request)
    {
        $input = $request->all();

        return $this->goods->getAllGoods($input);
    }


    /**
     * @param $goods
     *
     * @return \Illuminate\View\View
     */
    public function show($goods)
    {
        $goods       = urldecode($goods);
        $goodsDetail = $this->contracts->getDetailInfo($goods, "awards.items.classification.description");

        if ($goodsDetail->isEmpty()) {
            return view('error_404');
        }

        $totalAmount    = $this->getTotalAmount($goodsDetail);
        $contractsTrend = $this->contracts->getProcuringAgencyContractsByOpenYear($goods, 'goods');

        $contractTrend  = $this->getTrend($this->contracts->aggregateContracts($contractsTrend));


        $amountTrend     = $this->contracts->encodeToJson($contractsTrend, 'amount', 'view');
        $contractors     = $this->contracts->getContractors('amount', 5, ['from' => date('Y'), 'to' => date('Y')], $goods, "awards.items.classification.description");
        $procuringAgency = $this->contracts->getProcuringAgency('amount', 5, ['from' => date('Y'), 'to' => date('Y')], $goods, 'awards.items.classification.description');

        return view('goods.view', compact('goods', 'goodsDetail', 'totalAmount', 'contractTrend', 'amountTrend', 'contractors', 'procuringAgency'));
    }

    /**
     * @param $contracts
     *
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
     *
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
            $count++;
        }

        return json_encode($trends);
    }

    /**
     * @param                $goodsId
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function goodsDetailExport($goodsId)
    {
        return $this->exporter->getContractorDetailForExport(urldecode($goodsId), 'awards.items.classification.description');
    }

    public function exportGoods()
    {
        return $this->exporter->fetchGoods();
    }
}
