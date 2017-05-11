<?php

namespace App\Http\Controllers;


use App\Moldova\Service\ContractorService;
use App\Moldova\Service\Contracts;
use App\Moldova\Service\Email;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Moldova\Service\StreamExporter;
use Illuminate\Support\Facades\URL;

class ContractController extends Controller
{
    /**
     * @var Contracts
     */
    private $contracts;
    /**
     * @var StreamExporter
     */
    private $exporter;

    /**
     * ContractController constructor.
     *
     * @param Contracts      $contracts
     * @param StreamExporter $exporter
     */
    public function __construct(Contracts $contracts, StreamExporter $exporter)
    {
        $this->contracts = $contracts;
        $this->exporter  = $exporter;
    }

    /**
     * Contracts Index Function
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contractsTrends = $this->getTrend($this->contracts->getContractsByOpenYear());
        $totalContracts  = $this->contracts->getContractsCount("");

        return view('contracts.index', compact('contractsTrends', 'totalContracts'));
    }

    public function jsonView($contractId)
    {
        $contractJson = $this->contracts->getContractDataForJson($contractId);
        $response     = [
            "uri"           => URL::to('/')."/contracts/".$contractId."/json",
            "publishedDate" => "2016-06-10T10:30:00Z",
            "publisher"     => [
                "scheme" => "MD-PPA",
                "uid"    => "00000",
                "name"   => "Moldova Public Procurement Agency",
                "uri"    => "http://tender.gov.md/",
            ],
            'releases'      => [$contractJson],
        ];

        return response()->json($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Contractors Index function
     * @return \Illuminate\View\View
     */
    public function contractorIndex()
    {
        $contractorsTrends = $this->contracts->getContractors('amount', 5, ['from' => date('Y'), 'to' => date('Y')]);
        $contractorsCount  = $this->contracts->getContractorsCount("");

        return view('contracts.contractor-index', compact('contractorsTrends', 'contractorsCount'));
    }

    /**
     * @param ContractorService $contractorService
     * @param                   $contractor
     *
     * @return \Illuminate\View\View
     */
    public function show(ContractorService $contractorService, $contractor)
    {
        $contractor       = (urldecode($contractor));
        $contractorDetail = $this->contracts->getDetailInfo($contractor, 'awards.suppliers.name');

        if ($contractorDetail->isEmpty()) {
            return view('error_404');
        }

        $companyData   = $contractorService->fetchInfo($contractor);
        $courtCases    = $contractorService->fetchCourtData($contractor);
        $blacklist     = $contractorService->fetchBlacklist($contractor);
        $total         = $this->getTotal($contractorDetail);
        $totalContract = $total['totalContract'];
        $totalAmount   = $total['totalAmount'];

        $contractsTrend = $this->contracts->getProcuringAgencyContractsByOpenYear($contractor, 'contractor');

        $contractTrend    = $this->getTrend($this->contracts->aggregateContracts($contractsTrend));
        $amountTrend      = $this->contracts->encodeToJson($contractsTrend, 'amount', 'view');
        $procuringAgency  = $this->contracts->getProcuringAgency('amount', 5, ['from' => date('Y'), 'to' => date('Y')], $contractor, 'awards.suppliers.name');
        $goodsAndServices = $this->contracts->getGoodsAndServices('amount', 5, ['from' => date('Y'), 'to' => date('Y')], $contractor, 'awards.suppliers.name');

        return view(
            'contracts.contractor-view',
            compact(
                'contractor',
                'contractorDetail',
                'totalAmount',
                'contractTrend',
                'amountTrend',
                'procuringAgency',
                'goodsAndServices',
                'totalContract',
                'companyData',
                'courtCases',
                'blacklist'
            )
        );
    }

    /**
     * @param $contracts
     *
     * @return int
     */
    private function getTotal($contracts)
    {
        $totalAmount   = 0;
        $totalContract = 0;

        foreach ($contracts as $key => $tender) {
            $totalContract++;
            $totalAmount += $tender['amount'];

        }
        $total = ['totalAmount' => $totalAmount, 'totalContract' => $totalContract];

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
     * @param $contractId
     *
     * @return \Illuminate\View\View
     */
    public function view($contractId)
    {
        $contractDetail = $this->contracts->getContractDetailById($contractId);

        if (!$contractDetail) {
            return view('error_404');
        }

        $contractData = $this->contracts->getContractDataForJson($contractId);

        return view('contracts.view', compact('contractDetail', 'contractData'));
    }

    /**
     * @param $request
     * @param $client
     *
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
     * @param Email   $email
     * @param Client  $client
     *
     * @return $this
     */
    public function sendMessage(Request $request, Email $email, Client $client)
    {
        $input  = $request->all();
        $id     = $input['id'];
        $msg    = trans('general.verify_captcha');
        $status = 'Error';
        if ($this->checkFeedbackCaptcha($request, $client)) {

            $email->sendMessage($request->all());
            if ($email) {
                $status = 'success';
                $msg    = "Email sent successfully";
            } else {
                $status = 'error';
                $msg    = "Email sending failed";
            }
        }
        $response = [
            'status' => $status,
            'msg'    => $msg,
        ];

        return $response;
    }

    /**
     * @param $contractorId
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function contractorDetailExport($contractorId)
    {
        return $this->exporter->getContractorDetailForExport(urldecode($contractorId), 'awards.suppliers.name');
    }

    public function exportContractors()
    {
        return $this->exporter->fetchContractors();
    }


    /**
     * @param ContractorService $contractorService
     * @param                   $name
     * @param                   $type
     *
     * @return \Illuminate\View\View
     */
    public function linkage(ContractorService $contractorService, $name, $type)
    {
        $contractor = trim(urldecode($name));
        if ('company' === $type) {
            $linkageList = $contractorService->fetchInfo($contractor, 'all');
        } else {
            $linkageList = $contractorService->fetchCourtData($contractor, 'all');
        }

        return view('contracts.linkage', compact('linkageList', 'contractor', 'type'));
    }
}
