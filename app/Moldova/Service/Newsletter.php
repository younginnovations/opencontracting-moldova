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
     * NewsletterController constructor.
     *
     * @param Tenders                        $tenders
     * @param Contracts                      $contracts
     * @param Goods                          $goods
     * @param ProcuringAgency                $procuringAgency
     * @param StreamExporter                 $exporter
     * @param \App\Moldova\Service\MailChimp $mailChimp
     *
     * @internal param \App\Moldova\Service\MailChimp $mailChimp
     */
    public function __construct(
        Tenders $tenders,
        Contracts $contracts,
        Goods $goods,
        ProcuringAgency $procuringAgency,
        StreamExporter $exporter,
        MailChimp $mailChimp
    ) {
        $this->tenders         = $tenders;
        $this->contracts       = $contracts;
        $this->procuringAgency = $procuringAgency;
        $this->exporter        = $exporter;
        $this->goods           = $goods;
        $this->mailChimp       = $mailChimp;
    }


    /**
     * Content of newsletter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Request $request
     */
    public function getContentView()
    {
        $totalContractAmount      = round($this->contracts->getTotalContractAmount());
        $totalContractCount       = $this->contracts->getContractsList("");
        $totalAgency              = count($this->procuringAgency->getAllProcuringAgencyTitle());
        $totalGoods               = $this->goods->getAllGoods("");
        $totalContractorsCount    = $this->contracts->getContractorsCount();
        $procuringAgencyByAmount  = json_decode($this->contracts->getProcuringAgency('amount', 5, date('Y')));
        $contractorsByAmount      = json_decode($this->contracts->getContractors('amount', 5, date('Y')));
        $goodsAndServicesByAmount = json_decode($this->contracts->getGoodsAndServices('amount', 5, date('Y')));
        $procuringAgencyByCount   = json_decode($this->contracts->getProcuringAgency('count', 5, date('Y')));
        $contractorsByCount       = json_decode($this->contracts->getContractors('count', 5, date('Y')));
        $goodsAndServicesByCount  = json_decode($this->contracts->getGoodsAndServices('count', 5, date('Y')));

        return view(
            'newsletter.content',
            compact(
                'totalContractAmount',
                'totalContractCount',
                'totalAgency',
                'totalGoods',
                'totalContractorsCount',
                'procuringAgencyByAmount',
                'contractorsByAmount',
                'goodsAndServicesByAmount',
                'procuringAgencyByCount',
                'contractorsByCount',
                'goodsAndServicesByCount'
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
