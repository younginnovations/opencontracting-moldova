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

    public function downloadCsv(Request $request)
    {
        $input = $request->all();
        $input['length'] = 10000000;

        $result = (array) $this->tenders->getAllTenders($input);
        $result = $result["data"]->toArray();
        //temp array to construct array for csv
        $mResult = [];

        foreach ($result as $row) {
            $temp = [];
            $temp['id'] = $row["tender"]["id"];
            $temp['title'] = $row["tender"]["title"];
            $temp['status'] = $row["tender"]["status"];
            $temp['procuring_agency'] = $row["tender"]["procuringEntity"]["name"];
            $temp['start_date'] = $row["tender"]["tenderPeriod"]["startDate"]->toDateTime()->format('c');
            $temp['end_date'] = $row["tender"]["tenderPeriod"]["endDate"]->toDateTime()->format('c');
            array_push($mResult, $temp);
        }

        arrayToCsv($mResult, 'temp');
        $file = base_path('public').'/temp';
        return response()->download($file, 'tenders.csv');
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
