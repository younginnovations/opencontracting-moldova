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
    public function getProcuringAgency($type, $limit, $year, $condition, $column);

    /**
     * Get Contracts by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @param $condition
     * @param $column
     * @return mixed
     */
    public function getContractors($type, $limit, $year, $condition, $column);

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
    public function getGoodsAndServices($type, $limit, $year, $condition, $column);

    /**
     * Get list of contracts
     * @param $params
     * @return mixed
     */
    public function getContractsList($params);

    /**
     * Get list of contractors
     * @param $params
     * @return mixed
     */
    public function getContractorsList($params);


    /**
     * Get detail of Contractor or Procuring Agency by name
     * @param $parameter
     * @param $column
     * @return mixed
     */

    public function getDetailInfo($parameter, $column);

    /**
     * @param $contractId
     * @return mixed
     */
    public function getContractDetailById($contractId);

    /**
     * @param $search
     * @return mixed
     */
    public function search($search);

    /**
     * @return mixed
     */
    public function getAllContractTitle();

    /**
     * @param $contractId
     * @return mixed
     */
    public function getContractDataForJson($contractId);

    /**
     * @return mixed
     */
    public function getContractorsByOpenYear();

    /**
     * @return mixed
     */
    public function getContractorsCount();

    /**
     * @param $contractor
     * @param $limit
     * @return mixed
     */
    public function getCompanyData($contractor);

    /**
     * @param $contractor
     * @return mixed
     */
    public function getCourtCasesOfCompany($contractor);

    /**
     * @param $contractor
     * @return mixed
     */
    public function getBlacklistCompany($contractor);

    /**
     * @param $contractor
     * @return mixed
     */
    public function getContractorClearName($contractor);

}
