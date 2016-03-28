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
        $result = Contracts::raw(function ($collection) {
            return $collection->find([], [
                    "contractDate" => 1,
                    "_id"              => 1
                ]
            );
        });

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcuringAgency($type, $limit)
    {
        $groupBy = [
            [
                '$group' => [
                    '_id'    => '$tender.stateOrg.orgName',
                    'count'  => ['$sum' => 1],
                    'amount' => ['$sum' => '$amount']
                ]
            ],
            ['$sort' => [$type => - 1]],
            ['$limit' => $limit]
        ];

        $result = Contracts::raw(function ($collection) use ($groupBy) {
            return $collection->aggregate($groupBy);
        });

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getContractors($type, $limit)
    {
        $groupBy = [
            [
                '$group' => [
                    '_id'    => '$participant.fullName',
                    'count'  => ['$sum' => 1],
                    'amount' => ['$sum' => '$amount']
                ]
            ],
            ['$sort' => [$type => - 1]],
            ['$limit' => $limit]
        ];

        $result = Contracts::raw(function ($collection) use ($groupBy) {
            return $collection->aggregate($groupBy);
        });

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalContractAmount()
    {
        return $this->contracts->sum('amount');
    }

    /**
     * {@inheritdoc}
     */
    public function getGoodsAndServices($type, $limit)
    {
        $groupBy = [
            [
                '$group' => [
                    '_id'    => '$goods.mdValue',
                    'count'  => ['$sum' => 1],
                    'amount' => ['$sum' => '$amount']
                ]
            ],
            ['$sort' => [$type => - 1]],
            ['$limit' => $limit]
        ];

        $result = Contracts::raw(function ($collection) use ($groupBy) {
            return $collection->aggregate($groupBy);
        });

        return ($result);
    }

    public function getContractsList($limit)
    {

        $result = Contracts::raw(function ($collection) use ($limit) {
            return $collection->find([], [
                    "contractNumber" => 1,
                    "contractDate"   => 1,
                    "finalDate"      => 1,
                    "amount"         => 1,
                    "goods.mdValue"  => 1
                ]
            )->limit($limit);
        });

        return ($result);
    }
}
