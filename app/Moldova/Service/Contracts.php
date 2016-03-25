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
        $contracts          = $this->contracts->getContractsByOpenYear();
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
}
