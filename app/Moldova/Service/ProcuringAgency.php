<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\ProcuringAgency\ProcuringAgencyRepositoryInterface;

class ProcuringAgency
{
    /**
     * @var ProcuringAgencyRepositoryInterface
     */
    private $procuringAgency;

    /**
     * ProcuringAgency constructor.
     * @param ProcuringAgencyRepositoryInterface $procuringAgency
     */
    public function __construct(ProcuringAgencyRepositoryInterface $procuringAgency)
    {
        $this->procuringAgency = $procuringAgency;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getAllProcuringAgency($params)
    {
        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $this->getAgenciesCount(""),
            "recordsFiltered" => $this->getAgenciesCount($params),
            "data"            => $this->procuringAgency->getAllProcuringAgency($params)
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
}