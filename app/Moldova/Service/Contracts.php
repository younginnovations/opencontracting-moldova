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
     * @return mixed
     */
    public function getProcuringAgency($type, $limit, $condition = '')
    {
        return $this->encodeToJson($this->contracts->getProcuringAgency($type, $limit, $condition));
    }

    /**
     * Get Contractors by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getContractors($type, $limit)
    {
        return $this->encodeToJson($this->contracts->getContractors($type, $limit));
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
     * Get Goods And Services by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param string $condition
     * @return mixed
     */
    public function getGoodsAndServices($type, $limit, $condition = '')
    {
        return $this->encodeToJson($this->contracts->getGoodsAndServices($type, $limit, $condition));
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
     * @param $contractor
     * @return mixed
     */
    public function getContractorInfo($contractor)
    {
        return $this->contracts->getContractorInfo($contractor);
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
            $jsonData[$count]['value'] = ('trend' == $type) ? $val : $val['amount'];
            $count ++;
        }

        return json_encode($jsonData);
    }
}
