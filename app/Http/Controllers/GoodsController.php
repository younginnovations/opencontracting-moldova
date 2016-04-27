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
        $goodsAndServices = $this->contracts->getGoodsAndServices('amount', 5);

        return view('goods.index', compact('goodsAndServices'));
    }

    /**
     * Fetch all Goods
     * @param Request $request
     * @return mixed
     */
    public function getAllGoods(Request $request)
    {
        $input = $request->all();

        return $this->goods->getAllGoods($input);
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

        return view('goods.view', compact('goods', 'goodsDetail', 'totalAmount', 'contractTrend', 'amountTrend', 'contractors', 'procuringAgency'));
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

    /**
     * @param                $goodsId
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function goodsDetailExport($goodsId)
    {
        return $this->exporter->getContractorDetailForExport(urldecode($goodsId), 'award.items.classification.description');
    }

    public function exportGoods()
    {
        return $this->exporter->fetchGoods();
    }
}
