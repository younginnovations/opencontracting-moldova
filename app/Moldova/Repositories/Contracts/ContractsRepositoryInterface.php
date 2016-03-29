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
     * @param $condition
     * @param $column
     * @return mixed
     */
    public function getProcuringAgency($type, $limit, $condition, $column);

    /**
     * Get Contracts by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @param $condition
     * @param $column
     * @return mixed
     */
    public function getContractors($type, $limit,$condition, $column);

    /**
     * Gets total amount of Contracts
     * @return double
     */
    public function getTotalContractAmount();

    /**
     * Get Goods And Services by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @param $condition
     * @param $column
     * @return mixed
     */
    public function getGoodsAndServices($type, $limit, $condition, $column);

    /**
     * Get list of contracts
     * @param $limit
     * @return mixed
     */
    public function getContractsList($limit);

    /**
     * Get detail of Contractor or Procuring Agency by name
     * @param $contractor
     * @param $column
     * @return mixed
     */
    public function getDetailInfo($contractor, $column);
}
