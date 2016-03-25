<?php

namespace App\Moldova\Repositories\Contracts;


use App\Moldova\Entities\Contracts;

interface ContractsRepositoryInterface
{

    /**
     * @return Contracts
     */
    public function getContractsByOpenYear();

    /**
     * Get Procuring Agency by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getProcuringAgency($type, $limit);

    /**
     * Get Contracts by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getContractors($type, $limit);

    /**
     * Gets total amount of Contracts
     * @return double
     */
    public function getTotalContractAmount();

    /**
     * Get Goods And Services by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getGoodsAndServices($type, $limit);

    public function getContractsList($limit);
}
