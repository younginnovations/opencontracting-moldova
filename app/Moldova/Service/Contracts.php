<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\Contracts\ContractsRepositoryInterface;

class Contracts
{
    /**
     * @var ContractsRepositoryInterface
     */
    private $contracts;

    /**
     * Contracts constructor.
     * @param ContractsRepositoryInterface $contracts
     */
    public function __construct(ContractsRepositoryInterface $contracts)
    {
        $this->contracts = $contracts;
    }

    /**
     * @return array
     */
    public function getContractsByOpenYear()
    {
        return $this->aggregateContracts($this->contracts->getContractsByOpenYear());

    }

    public function aggregateContracts($contracts, $type = '')
    {
        $contractsByOpenYear = [];

        foreach ($contracts as $contract) {

            $year = explode(".", $contract['contractDate']);

            if (array_key_exists($year[2], $contractsByOpenYear)) {
                $contractsByOpenYear[$year[2]] += ('amount' == $type) ? $contract['amount'] : 1;
            } else {
                $contractsByOpenYear[$year[2]] = ('amount' == $type) ? $contract['amount'] : 1;
            }

        }

        return $contractsByOpenYear;
    }

    /**
     * Get Procuring Agency by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param string $condition
     * @param        $column
     * @return mixed
     */
    public function getProcuringAgency($type, $limit, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getProcuringAgency($type, $limit, $condition, $column), $type);
    }

    /**
     * Get Contractors by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param string $condition
     * @param        $column
     * @return mixed
     */
    public function getContractors($type, $limit, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getContractors($type, $limit, $condition, $column), $type);
    }

    /**
     * Get Goods And Services by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param string $condition
     * @param        $column
     * @return mixed
     */
    public function getGoodsAndServices($type, $limit, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getGoodsAndServices($type, $limit, $condition, $column), $type);
    }

    /**
     * Gets total amount of Contracts
     * @return float
     */
    public function getTotalContractAmount()
    {
        return $this->contracts->getTotalContractAmount();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getContractsList($limit)
    {
        return $this->contracts->getContractsList($limit);
    }

    /**
     * Find Contractor or Procuring Agency Info according to params provided
     * @param $parameter
     * @param $column
     * @return mixed
     */
    public function getDetailInfo($parameter, $column)
    {
        return $this->contracts->getDetailInfo($parameter, $column);
    }

    /**
     * @param        $data
     * @param        $type
     * @return string
     */
    public function encodeToJson($data, $type = '')
    {
        $jsonData = [];
        $count    = 0;
        $data     = ('trend' == $type) ? $data : $data['result'];

        ksort($data);

        foreach ($data as $key => $val) {
            $jsonData[$count]['name']  = ('trend' == $type) ? $key : $val['_id'];
            $jsonData[$count]['value'] = ('trend' == $type) ? $val : $val[$type];
            $count ++;
        }

        return json_encode($jsonData);
    }
}
