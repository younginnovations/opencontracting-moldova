<?php

namespace App\Http\Controllers;


use App\Moldova\Service\Contracts;
use App\Moldova\Service\Email;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

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

    /**
     * Contracts Index Function
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contractsTrends = $this->getTrend($this->contracts->getContractsByOpenYear());

        return view('contracts.index', compact('contractsTrends'));
    }

    /**
     * Contractors Index function
     * @return \Illuminate\View\View
     */
    public function contractorIndex()
    {
        $contractorsTrends = $this->contracts->getContractors('amount', 5);
        $contractors       = $this->contracts->getContractorsByOpenYear();

        return view('contracts.contractor-index', compact('contractorsTrends', 'contractors'));
    }

    /**
     * @param $contractor
     * @return \Illuminate\View\View
     */
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
     * @param $contractId
     * @return \Illuminate\View\View
     */
    public function view($contractId)
    {//dd($contractId);
        $contractDetail = $this->contracts->getContractDetailById($contractId);
        $contractData   = $this->contracts->getContractDataForJson($contractId);

        return view('contracts.view', compact('contractDetail', 'contractData'));
    }

    /**
     * @param $request
     * @param $client
     * @return bool
     */
    public function checkFeedbackCaptcha($request, $client)
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
     * @param Email $email
     * @param Client $client
     * @return $this
     */
    public function sendMessage(Request $request, Email $email, Client $client)
    {
        $input = $request->all();
        $id = $input['id'];
        $msg = 'Please verify the captcha';
        $status = 'Error';
        if ($this->checkFeedbackCaptcha($request, $client)) {

            $email->sendMessage($request->all());
            if ($email) {
                $status = 'success';
                $msg = "Email sent successfully";
            }else{
                $status = 'error';
                $msg = "Email sending failed";
            }
        }
        $response = array(
            'status' => $status,
            'msg' => $msg,
        );

        return  $response;
//        return redirect()->route('contracts.view', ['id' => $id]);
    }
}
