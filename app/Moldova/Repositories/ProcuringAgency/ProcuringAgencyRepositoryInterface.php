<?php

namespace App\Moldova\Repositories\ProcuringAgency;


interface ProcuringAgencyRepositoryInterface
{

    /**
     * @param $params
     * @return mixed
     */
    public function getAllProcuringAgency($params);

    /**
     * Get count of procuring Agencies
     * @param $params
     *
     * @return mixed
     */
    public function getProcuringAgenciesCount($params);

    /**
     * @return mixed
     */
    public function getAllProcuringAgencyTitle();

    /**
     * @param $procuringAgency
     * @return mixed
     */
    public function getAgencyData($procuringAgency);

    /**
     * @param $agency
     *
     * @return mixed
     */
    public function getTendersCount($agency);
}
