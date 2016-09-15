<?php

namespace App\Http\Controllers;


use App\Moldova\Service\StreamExporter;
use App\Moldova\Service\Tenders;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * @var Tenders
     */
    private $tenders;
    /**
     * @var StreamExporter
     */
    private $exporter;

    /**
     * TenderController constructor.
     * @param Tenders        $tenders
     * @param StreamExporter $exporter
     */
    public function __construct(Tenders $tenders, StreamExporter $exporter)
    {

        $this->tenders  = $tenders;
        $this->exporter = $exporter;
    }

    /**
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $tendersTrends = $this->getTrend($this->tenders->getTendersByOpenYear());

        return view('tender.index', compact('tendersTrends'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTenders(Request $request)
    {
        $input = $request->all();

        return $this->tenders->getAllTenders($input);
    }


    /**
     * @param $tenderID
     * @return \Illuminate\View\View
     */
    public function show($tenderID)
    {
        $tenderDetail = $this->tenders->getTenderDetailByID($tenderID);

        if (empty($tenderDetail)) {
            return view('error_404');
        }

        $feedbackData = $this->tenders->getTenderFeedback($tenderDetail['tender']['title']);

        return view('tender.view', compact('tenderDetail', 'feedbackData'));

    }

    /**
     * @param $tenders
     * @return string
     */
    private function getTrend($tenders)
    {
        $trends = [];
        $count  = 0;
        ksort($tenders);

        foreach ($tenders as $key => $trend) {
            $trends[$count]['xValue'] = $key;
            $trends[$count]['chart1'] = 0;
            $trends[$count]['chart2'] = $trend;
            $count ++;
        }

        return json_encode($trends);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTenders()
    {
        return $this->exporter->fetchTenders();
    }

    /**
     * @param $tenderId
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTenderGoods($tenderId)
    {
//        return $this->exporter->fetchTenderGoods($tenderId);
    }

    /**
     * @param $tenderId
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTenderContracts($tenderId)
    {
//        return $this->exporter->fetchTenderContracts($tenderId);
    }

}
