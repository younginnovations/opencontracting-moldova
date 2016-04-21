<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Email;
use App\Moldova\Service\ProcuringAgency;
use App\Moldova\Service\Tenders;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use ReCaptcha\Captcha;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


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
     * ExampleController constructor.
     * @param Tenders         $tenders
     * @param Contracts       $contracts
     * @param ProcuringAgency $procuringAgency
     */
    public function __construct(Tenders $tenders, Contracts $contracts, ProcuringAgency $procuringAgency)
    {
        $this->tenders         = $tenders;
        $this->contracts       = $contracts;
        $this->procuringAgency = $procuringAgency;
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
        $procuringAgency     = $this->contracts->getProcuringAgency('amount', 5);
        $contractors         = $this->contracts->getContractors('amount', 5);
        $goodsAndServices    = $this->contracts->getGoodsAndServices('amount', 5);

        // $contractsList       = $this->contracts->getContractsList(10);

        return view('index', compact('totalContractAmount', 'trends', 'procuringAgency', 'contractors', 'goodsAndServices'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        $input = $request->all();

        return $this->contracts->getContractsList($input);

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

        switch ($type) {
            case ('contractor'):
                $data = $this->contracts->getContractors($filterBy, 5, $param, $dataFor);
                break;
            case ('agency'):
                $data = $this->contracts->getProcuringAgency($filterBy, 5, $param, $dataFor);
                break;
            case ('goods'):
                $data = $this->contracts->getGoodsAndServices($filterBy, 5, $param, $dataFor);
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
                $column = 'participant.fullName';
                break;
            case ('agency'):
                $column = 'tender.stateOrg.orgName';
                break;
            case ('goods'):
                $column = 'goods.mdValue';
                break;
        }

        return $column;
    }

    public function search(Request $request)
    {
        $contractTitles    = $this->contracts->getAllContractTitle();
        $procuringAgencies = $this->procuringAgency->getAllProcuringAgencyTitle();

//        $search     = $request->get('q');
//        $contractor = $request->get('contractor');
//        $agency     = $request->get('agency');
//        $range      = $request->get('amount');

        $contracts = [];
        $params    = $request->all();
        if (!empty($request->get('q')) || !empty($request->get('contractor')) || !empty($request->get('agency')) || !empty($request->get('amount'))) {
            //$params = $request->all();

            $contracts = $this->contracts->search($params);
        }


        return view('search', compact('contracts', 'contractTitles', 'procuringAgencies', 'params'));
    }

    /**
     * @return bool
     */
    public function checkCaptcha($request,$client)
    {
        $params = ['body' => ['secret' => env('RE_CAP_SECRET'), 'response' => $request->get('g-recaptcha-response'), 'remoteip' => $request->ip()]];
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', $params);
        $response = ($response->json());

        if($response['success'] === true){
            return true;
        }

        return false;
    }

    public function sendMessage(Request $request, Email $email, Client $client)
    {
        if($this->checkCaptcha($request, $client)){

            $email->sendMessage($request->all());

            if($email){
                return view('contact')->withSuccess('Your message has been sent. Will be in touch with you soon.');
            }

            return view('contact')->withErrors("Sorry your email can't be sent at the moment, please try again later");
        }
        return view('contact')->withErrors("Please verify the captcha");
    }
}
