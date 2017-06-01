<?php
namespace App\Moldova\Service;


use GuzzleHttp\Exception\RequestException;

class Newsletter
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
     * @var ProcuringAgency
     */
    private $procuringAgency;
    /**
     * @var StreamExporter
     */
    private $exporter;
    /**
     * @var Tenders
     */
    private $tenders;
    /**
     * @var \App\Moldova\Service\MailChimp
     */
    private $mailChimp;

    /**
     * @var \App\Moldova\Service\Dashboard
     */
    private $dashboard;

    /**
     * NewsletterController constructor.
     *
     * @param Tenders $tenders
     * @param Contracts $contracts
     * @param Goods $goods
     * @param ProcuringAgency $procuringAgency
     * @param StreamExporter $exporter
     * @param \App\Moldova\Service\MailChimp $mailChimp
     * @param \App\Moldova\Service\Dashboard $dashboard
     * @internal param \App\Moldova\Service\MailChimp $mailChimp
     */
    public function __construct(
        Tenders $tenders,
        Contracts $contracts,
        Goods $goods,
        ProcuringAgency $procuringAgency,
        StreamExporter $exporter,
        MailChimp $mailChimp,
        Dashboard $dashboard
    ) {
        $this->tenders         = $tenders;
        $this->contracts       = $contracts;
        $this->procuringAgency = $procuringAgency;
        $this->exporter        = $exporter;
        $this->goods           = $goods;
        $this->mailChimp       = $mailChimp;
        $this->dashboard      = $dashboard;
    }


    /**
     * Content of newsletter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Request $request
     */
    public function getContentView()
    {
        //total
        $totalContractAmount      = round($this->contracts->getTotalContractAmount());
        $totalContractCount       = $this->contracts->getContractsCount("");
        $totalAgency              = count($this->procuringAgency->getAllProcuringAgencyTitle());
        $totalGoods               = $this->goods->getGoodsCount("");
        $totalContractorsCount    = $this->contracts->getContractorsCount("");

        //yearly
        $yearTotalContracts = round($this->contracts->getYearContractAmount(date('Y')));
        $getYearContractorsCount = $this->contracts->getYearContractorsCount(date('Y'));
        $endingSoon = $this->contracts->getEndingSoon();
        $recentlySigned = $this->contracts->getRecentlySigned();

        //import date
        $import_date = $this->dashboard->getLastImportDate();


        //$procuringAgencyByAmount  = json_decode($this->contracts->getProcuringAgency('amount', 5, ['from' => date('Y'), 'to' => date('Y')]));
       // $contractorsByAmount      = json_decode($this->contracts->getContractors('amount', 5, ['from' => date('Y'), 'to' => date('Y')]));
      //  $goodsAndServicesByAmount = json_decode($this->contracts->getGoodsAndServices('amount', 5, ['from' => date('Y'), 'to' => date('Y')]));
        $procuringAgencyByCount   = json_decode($this->contracts->getProcuringAgency('count', 5, ['from' => date('Y'), 'to' => date('Y')]));
        $contractorsByCount       = json_decode($this->contracts->getContractors('count', 5, ['from' => date('Y'), 'to' => date('Y')]));
        $goodsAndServicesByCount  = json_decode($this->contracts->getGoodsAndServices('count', 5, ['from' => date('Y'), 'to' => date('Y')]));

        return view(
            'newsletter.content',
            compact(
                'yearTotalContracts',
                'totalContractAmount',
                'totalContractCount',
                'totalAgency',
                'totalGoods',
                'totalContractorsCount',
               // 'procuringAgencyByAmount',
               // 'contractorsByAmount',
               // 'goodsAndServicesByAmount',
                'procuringAgencyByCount',
                'contractorsByCount',
                'goodsAndServicesByCount',
                'getYearContractorsCount',
                'endingSoon',
                'recentlySigned',
                'import_date'
            )
        );
    }

    /**
     * Create campaign, set content and send from MailChimp
     *
     * @param $title
     * @param $subject
     */
    public function createAndSendCampaign($title, $subject)
    {
        $html     = (string) $this->getContentView();
        $campaign = json_decode($this->mailChimp->createCampaign($title, $subject));
        $this->mailChimp->setContent($campaign->id,$html);
        $this->mailChimp->sendCampaign($campaign->id);
    }

    /**
     * @param $email
     */
    public function subscribeUser($email){
        try{
            $this->mailChimp->subscribeUser($email);
        }catch (RequestException $e){
            throw $e;
        }
    }
}
