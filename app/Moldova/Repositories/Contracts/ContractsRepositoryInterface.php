<?php

namespace App\Moldova\Repositories\Contracts;


use App\Moldova\Entities\Contracts;

interface ContractsRepositoryInterface
{

    /**
     * @return Contracts
     */
    public function getContractsByOpenYear();
}
