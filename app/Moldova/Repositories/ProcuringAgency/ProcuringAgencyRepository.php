<?php

namespace App\Moldova\Repositories\ProcuringAgency;


use App\Moldova\Entities\OcdsRelease;

class ProcuringAgencyRepository implements ProcuringAgencyRepositoryInterface
{
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;

    /**
     * ProcuringAgencyRepository constructor.
     * @param OcdsRelease $ocdsRelease
     */
    public function __construct(OcdsRelease $ocdsRelease)
    {

        $this->ocdsRelease = $ocdsRelease;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProcuringAgency($params)
    {
        $orderIndex  = $params['order'][0]['column'];
        $ordDir      = $params['order'][0]['dir'];
        $column      = $params['columns'][$orderIndex]['data'];
        $startFrom   = $params['start'];
        $ordDir      = (strtolower($ordDir) == 'asc') ? 1 : - 1;
        $search      = $params['search']['value'];
        $limitResult = $params['length'];

        $agencies = $this->ocdsRelease
            //->select(['buyer.name'])
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    return $query->where('buyer.name', 'like', '%' . $search . '%');
                }

                return $query;
            })
            //->skip($startFrom)
            ->orderBy($column, $ordDir)
            ->distinct()
            ->get(['buyer.name']);
        $agencies = ($agencies->splice($startFrom)->take($limitResult));

        $buyers = [];
        foreach ($agencies as $key => $agency) {

            $buyer = $this->getBuyerDetails($agency[0]);

            $buyers[$key]['buyer']          = $agency[0];
            $buyers[$key]['tender']         = $buyer['tenderCount'];
            $buyers[$key]['contract']       = $buyer['contractCount'];
            $buyers[$key]['contract_value'] = $buyer['amount'];

        }

        return $buyers;
    }

    /**
     * @param $buyerName
     * @return array
     */
    protected function getBuyerDetails($buyerName)
    {
        $buyer  = $this->ocdsRelease->where('buyer.name', '=', $buyerName)->get(['contract']);
        $count  = 0;
        $amount = 0;
        foreach ($buyer as $item) {
            $count = $count + count($item['contract']);
            foreach ($item['contract'] as $contract) {
                $amount = floatval($amount)+ floatval($contract['value']);
            }
        }

        return ['tenderCount' => count($buyer), 'contractCount' => $count, 'amount' => $amount];
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProcuringAgencyTitle()
    {
        return $this->ocdsRelease
            ->distinct('buyer.name')
            ->orderBy('buyer.name', 'ASC')
            ->get();
    }

    /**
     * @param $procuringAgency
     * @return mixed
     */
    public function getAgencyData($procuringAgency)
    {
        return $this->ocdsRelease
            ->select(['buyer'])
            ->where('buyer.name','=',$procuringAgency)
            ->first();
    }
}