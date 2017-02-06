<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Email;
use App\Moldova\Service\ProcuringAgency;
use App\Moldova\Service\StreamExporter;
use App\Moldova\Service\Tenders;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use ReCaptcha\Captcha;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class HomeController extends Controller
{
    /**
     * @var Contracts
     */
    private $contracts;
    /**
     * @var ProcuringAgency
     */
    private $procuringAgency;
    /**
     * @var StreamExporter
     */
    private $exporter;

    /**
     * ExampleController constructor.
     * @param Tenders         $tenders
     * @param Contracts       $contracts
     * @param ProcuringAgency $procuringAgency
     * @param StreamExporter  $exporter
     */
    public function __construct(Tenders $tenders, Contracts $contracts, ProcuringAgency $procuringAgency, StreamExporter $exporter)
    {
        $this->tenders         = $tenders;
        $this->contracts       = $contracts;
        $this->procuringAgency = $procuringAgency;
        $this->exporter        = $exporter;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalContractAmount = round($this->contracts->getTotalContractAmount());
        $tendersTrends       = $this->tenders->getTendersByOpenYear();
        $contractsTrends     = $this->contracts->getContractsByOpenYear();
        $trends              = $this->mergeContractAndTenderTrends($tendersTrends, $contractsTrends);
        $procuringAgency     = $this->contracts->getProcuringAgency('amount', 5, date('Y'));
        $contractors         = $this->contracts->getContractors('amount', 5, date('Y'));
        $goodsAndServices    = $this->contracts->getGoodsAndServices('amount', 5, date('Y'));
        $contractTitles      = $this->contracts->getAllContractTitle();
        $procuringAgencies   = $this->procuringAgency->getAllProcuringAgencyTitle();

        return view('index', compact('totalContractAmount', 'trends', 'procuringAgency', 'contractors', 'goodsAndServices', 'contractTitles', 'procuringAgencies'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        $input = $request->all();
        $data  = $this->contracts->getContractsList($input);

        return $data;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getContractorData(Request $request)
    {
        $input = $request->all();

        return $this->contracts->getContractorsList($input);

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
            $count ++;
        }

        return json_encode($trends);
    }

    /**
     * API call to sort data by count or amount
     * @param Request $request
     * @return mixed
     */
    public function filter(Request $request)
    {
        $filterBy = $request->get('filter');
        $type     = $request->get('type');
        $dataFor  = ($request->get('dataFor')) ? $this->getColumnName($request->get('dataFor')) : '';
        $param    = ($request->get('param')) ? $request->get('param') : '';
        $year     = ($request->get('year')) ? $request->get('year') : date('Y');

        switch ($type) {
            case ('contractor'):
                $data = $this->contracts->getContractors($filterBy, 5, $year, $param, $dataFor);
                break;
            case ('agency'):
                $data = $this->contracts->getProcuringAgency($filterBy, 5, $year, $param, $dataFor);
                break;
            case ('goods'):
                $data = $this->contracts->getGoodsAndServices($filterBy, 5, $year, $param, $dataFor);
                break;

        }

        return $data;
    }

    /**
     * Get column name to search for according to sort data
     * @param $type
     * @return string
     */
    protected function getColumnName($type)
    {
        $column = '';

        switch ($type) {
            case ('contractor'):
                $column = 'awards.suppliers.name';
                break;
            case ('agency'):
                $column = 'tender.procuringEntity.name';
                break;
            case ('goods'):
                $column = 'awards.items.classification.description';
                break;
        }

        return $column;
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $contractTitles    = $this->contracts->getAllContractTitle();
        $procuringAgencies = $this->procuringAgency->getAllProcuringAgencyTitle();
        $contracts         = [];
        $params            = $request->all();

        if (!empty($request->get('q')) || !empty($request->get('contractor')) || !empty($request->get('agency')) || !empty($request->get('amount')) || !empty($request->get('startDate')) || !empty($request->get('endDate'))) {
            $contracts = $this->contracts->search($params);

            if ($request->get('export')) {
                return $this->exporter->exportSearch($contracts);
            }

        }

        return view('search', compact('contracts', 'contractTitles', 'procuringAgencies', 'params'));
    }

    /**
     * @param $request
     * @param $client
     *
     * @return bool
     */
    public function checkCaptcha($request, $client)
    {
        $params   = ['body' => ['secret' => env('RE_CAP_SECRET'), 'response' => $request->get('g-recaptcha-response'), 'remoteip' => $request->ip()]];
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', $params);
        $response = ($response->json());

        if ($response['success'] === true) {
            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @param Email   $email
     * @param Client  $client
     * @return $this
     */
    public function sendMessage(Request $request, Email $email, Client $client)
    {
        $msg    = 'Please verify the captcha';
        $status = 'Error';

        if ($this->checkCaptcha($request, $client)) {
            $email->sendMessage($request->all());

            if ($email) {
                $status = 'success';
                $msg    = "Email sent successfully";
            } else {
                $status = 'error';
                $msg    = "Email sending failed";
            }
        }

        $response = array(
            'status' => $status,
            'msg'    => $msg,
        );

        return $response;
    }


    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return $this->exporter->getAllContracts();

    }
}
