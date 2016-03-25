<?php

namespace App\Moldova\Repositories\Contracts;


use App\Moldova\Entities\Contracts;

class ContractsRepository implements ContractsRepositoryInterface
{
    /**
     * @var Contracts
     */
    private $contracts;

    /**
     * ContractsRepository constructor.
     * @param Contracts $contracts
     */
    public function __construct(Contracts $contracts)
    {
        $this->contracts = $contracts;
    }

    /**
     * {@inheritdoc}
     */
    public function getContractsByOpenYear()
    {
        return $this->contracts->get();
    }
}
