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
     * @return mixed
     */
    public function getAllProcuringAgencyTitle();
}