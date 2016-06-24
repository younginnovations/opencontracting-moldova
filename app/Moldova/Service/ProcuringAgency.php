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
        $totalAgencies = count($this->procuringAgency->getAllProcuringAgencyTitle());
        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $totalAgencies,
            "recordsFiltered" => $totalAgencies,
            "data"            => $this->procuringAgency->getAllProcuringAgency($params)
        ];
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