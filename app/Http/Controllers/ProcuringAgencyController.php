<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Contracts;
use App\Moldova\Service\ProcuringAgency;
use App\Moldova\Service\StreamExporter;
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
     * @var StreamExporter
     */
    private $exporter;

    /**
     * ContractController constructor.
     *
     * @param Contracts       $contracts
     * @param Tenders         $tenders
     * @param ProcuringAgency $procuringAgency
     * @param StreamExporter  $exporter
     */
    public function __construct(Contracts $contracts, Tenders $tenders, ProcuringAgency $procuringAgency, StreamExporter $exporter)
    {
        $this->contracts       = $contracts;
        $this->tenders         = $tenders;
        $this->procuringAgency = $procuringAgency;
        $this->exporter        = $exporter;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $procuringAgency = $this->contracts->getProcuringAgency('amount', 5, ['from' => date('Y'), 'to' => date('Y')]);
        $totalAgency     = count($this->procuringAgency->getAllProcuringAgencyTitle());

        return view('agency.index', compact('procuringAgency', 'totalAgency'));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getProcuringAgency(Request $request)
    {
        $input = $request->all();

        return $this->procuringAgency->getAllProcuringAgency($input);
    }

    /**
     * @param $procuringAgency
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($procuringAgency)
    {
        $procuringAgency = urldecode($procuringAgency);
        $agencyData      = $this->procuringAgency->getAgencyData($procuringAgency);

        if (empty($agencyData)) {
            return view('error_404');
        }

        $procuringAgencyDetail = $this->contracts->getDetailInfo($procuringAgency, "buyer.name");
        $totalAmount           = $this->getTotalAmount($procuringAgencyDetail);
        $tenderTrends          = $this->tenders->getProcuringAgencyTenderByOpenYear($procuringAgency);
        $contractsTrend        = $this->contracts->getProcuringAgencyContractsByOpenYear($procuringAgency,'buyer');
        $trends                = $this->mergeContractAndTenderTrends($tenderTrends, $this->contracts->aggregateContracts($contractsTrend));
        $amountTrend           = $this->contracts->encodeToJson($contractsTrend, 'amount','view');
        $contractors           = $this->contracts->getContractors('amount', 5, ['from' => date('Y'), 'to' => date('Y')], $procuringAgency, "tender.procuringEntity.name");

        $goodsAndServices = $this->contracts->getGoodsAndServices('amount', 5, ['from' => date('Y'), 'to' => date('Y')], $procuringAgency, "tender.procuringEntity.name");

        return view(
            'agency.view',
            compact('agencyData', 'procuringAgency', 'procuringAgencyDetail', 'totalAmount', 'trends', 'amountTrend', 'contractors', 'goodsAndServices')
        );
    }

    /**
     * @param $contracts
     *
     * @return int
     */
    private function getTotalAmount($contracts)
    {
        $total = 0;

        foreach ($contracts as $key => $tender) {
            foreach ($tender['contracts'] as $contract) {
                $total += $contract['value']['amount'];
            }
        }

        return ($total);
    }

    protected function mergeContractAndTenderTrends($tendersTrends, $contractsTrends)
    {
        $trends = [];
        $count  = 0;

        $years = (array_unique(array_merge(array_keys($tendersTrends), array_keys($contractsTrends))));
        asort($years);

        foreach ($years as $key => $year) {
            $trends[$count]['xValue'] = $year;
            $trends[$count]['chart1'] = isset($tendersTrends[$year]) ? $tendersTrends[$year] : 0;
            $trends[$count]['chart2'] = isset($contractsTrends[$year]) ? $contractsTrends[$year] : 0;
            $count++;
        }

        return json_encode($trends);
    }

    /**
     * @param                $agencyId
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function agencyDetailExport($agencyId)
    {
        return $this->exporter->getContractorDetailForExport(urldecode($agencyId), 'buyer.name');
    }

    public function exportAgencies()
    {
        return $this->exporter->fetchAgencies();
    }
}
