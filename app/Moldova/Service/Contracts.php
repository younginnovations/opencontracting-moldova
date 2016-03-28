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
        $contracts           = $this->contracts->getContractsByOpenYear();
        $contractsByOpenYear = [];

        foreach ($contracts as $contract) {

            $year = explode(".", $contract['contractDate']);

            if (array_key_exists($year[2], $contractsByOpenYear)) {
                $contractsByOpenYear[$year[2]] += 1;
            } else {
                $contractsByOpenYear[$year[2]] = 1;
            }

        }

        return $contractsByOpenYear;
    }

    /**
     * Get Procuring Agency by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getProcuringAgency($type, $limit)
    {
        return $this->contracts->getProcuringAgency($type, $limit);
    }

    /**
     * Get Contractors by amount/count according to type and by limit given
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getContractors($type, $limit)
    {
        return $this->contracts->getContractors($type, $limit);
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
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getGoodsAndServices($type, $limit)
    {
        return $this->contracts->getGoodsAndServices($type, $limit);
    }

    public function getContractsList($limit)
    {
        return $this->contracts->getContractsList($limit);
    }
}
