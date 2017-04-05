<?php

namespace App\Moldova\Repositories\ProcuringAgency;


use App\Moldova\Entities\OcdsRelease;
use App\Moldova\Service\StringUtil;
use MongoDB\BSON\Regex;


class ProcuringAgencyRepository implements ProcuringAgencyRepositoryInterface
{
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;

    /**
     * ProcuringAgencyRepository constructor.
     *
     * @param OcdsRelease $ocdsRelease
     */
    public function __construct(OcdsRelease $ocdsRelease)
    {

        $this->ocdsRelease = $ocdsRelease;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProcuringAgency($params)
    {
        $orderIndex  = $params['order'][0]['column'];
        $ordDir      = (strtolower($params['order'][0]['dir']) == 'asc') ? 1 : -1;
        $column      = $this->getColumnTitle($params['columns'][$orderIndex]['data']);
        $startFrom   = $params['start'];
        $search      = $params['search']['value'];
        $limitResult = $params['length'];

        $search = StringUtil::accentToRegex($search);


        $query  = [];
        $filter = [];

        if ($search != '') {
            $filter = [
                '$match' => ['buyer.name' => new Regex(".*$search.*", 'i')],
            ];
        }

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $project = [
            '$project' => [
                'buyer'          => '$buyer.name',
                'awards'         => ['$size' => '$awards'],
                'contract_value' => '$contracts.value.amount',
            ],
        ];


        $groupBy = [
            '$group' => [
                '_id'             => '$buyer',
                'tenders'         => ['$sum' => 1],
                'contracts_count' => ['$sum' => '$awards'],
                'contract_value'  => ['$addToSet' => '$contract_value'],
            ],
        ];


        if ($column === 'contract_value') {
            $unwind = [
                '$unwind' => '$contracts',
            ];
            array_push($query, $unwind);

            $project = [
                '$project' => [
                    'buyer'          => '$buyer.name',
                    //                    'awards'         => ['$size' => '$awards'],
                    'contract_value' => '$contracts.value.amount',
                ],
            ];

            $groupBy = [
                '$group' => [
                    '_id'             => '$buyer',
                    'tenders'         => ['$sum' => 1],
                    'contracts_count' => ['$sum' => 1],
                    'contract_value'  => ['$sum' => '$contract_value'],
                ],
            ];

        }

        array_push($query, $project);
        array_push($query, $groupBy);


        $sort = ['$sort' => [$column => $ordDir]];
        array_push($query, $sort);
        $skip = ['$skip' => (int) $startFrom];
        array_push($query, $skip);
        $limit = ['$limit' => (int) $limitResult];
        array_push($query, $limit);

        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        );

        return ($result);
    }

    public function getProcuringAgenciesCount($params)
    {
        $search = "";
        if ($params != "") {
            $search = $params['search']['value'];
            $search = StringUtil::accentToRegex($search);
        }

        $query = [];

        if ($search != "") {
            $filter = [
                '$match' => ['buyer.name' => new Regex(".*$search.*", 'i')],
            ];
            array_push($query, $filter);
        }

        $groupBy = [
            '$group' => [
                '_id' => '$buyer.name',
            ],
        ];
        array_push($query, $groupBy);

        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        );

        return count($result);
    }

    protected function getColumnTitle($column)
    {
        switch ($column) {
            case '0':
                $column = '_id';
                break;
            case '1':
                $column = 'tenders';
                break;
            case '2':
                $column = 'contracts_count';
                break;
            case '3':
                $column = 'contract_value';
                break;
            default:
                break;
        }

        return $column;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProcuringAgencyTitle()
    {
        return $this->ocdsRelease->distinct('buyer.name')->orderBy('buyer.name', 'ASC')->get();
    }

    /**
     * @param $procuringAgency
     *
     * @return mixed
     */
    public function getAgencyData($procuringAgency)
    {
        return $this->ocdsRelease->select(['buyer'])->where('buyer.name', '=', $procuringAgency)->first();
    }

    /**
     * @param $agency
     *
     * @return mixed
     */
    public function getTendersCount($agency)
    {
        $result = OcdsRelease::raw(
            function ($collection) use ($agency) {
                return $collection->aggregate(
                    [
                        ['$match' => ['buyer.name' => $agency]],
                        [
                            '$group' => [
                                '_id'     => 'buyer.name',
                                'tenders' => ['$sum' => 1],
                            ],
                        ],
                    ]
                );
            }
        );

        return ($result[0]['tenders']);
    }
}
