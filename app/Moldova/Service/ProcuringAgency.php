<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\ProcuringAgency\ProcuringAgencyRepositoryInterface;
//use function MongoDB\BSON\toPHP;
use MongoDB\Model\BSONArray;

class ProcuringAgency
{
    /**
     * @var ProcuringAgencyRepositoryInterface
     */
    private $procuringAgency;

    /**
     * ProcuringAgency constructor.
     *
     * @param ProcuringAgencyRepositoryInterface $procuringAgency
     */
    public function __construct(ProcuringAgencyRepositoryInterface $procuringAgency)
    {
        $this->procuringAgency = $procuringAgency;
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function getAllProcuringAgency($params)
    {

        $agencyList = $this->procuringAgency->getAllProcuringAgency($params);

        if ($params['order'][0]['column'] != 3) {
            foreach ($agencyList as $key => $agency) {
                $sum                                = $this->getContractsValue($agency['contract_value']);
                $agencyList[$key]['contract_value'] = $sum;
            }
        } else {
            foreach ($agencyList as $key => $agency) {
                $agencyList[$key]['tenders'] = $this->procuringAgency->getTendersCount($agency['_id']);
            }
        }

        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $this->getAgenciesCount(""),
            "recordsFiltered" => $this->getAgenciesCount($params),
            "data"            => $agencyList,
        ];
    }

    public function getAgenciesCount($params)
    {
        return $this->procuringAgency->getProcuringAgenciesCount($params);
    }

    public function getAllProcuringAgencyTitle()
    {
        return $this->procuringAgency->getAllProcuringAgencyTitle();
    }

    public function getAgencyData($procuringAgency)
    {
        return $this->procuringAgency->getAgencyData($procuringAgency);
    }

    private function getContractsValue($contracts)
    {
        $sum = 0;
        foreach ($contracts as $key => $contract) {

            if (sizeof($contract) > 0) {
                foreach ($contract as $key => $val) {
                    $sum += $val;
                }
            }

        }

        return $sum;
    }
}