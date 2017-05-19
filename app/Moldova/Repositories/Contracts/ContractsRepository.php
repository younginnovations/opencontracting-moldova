<?php namespace App\Moldova\Repositories\Contracts;

use App\Moldova\Entities\Blacklist;
use App\Moldova\Entities\CompaniesDetail;
use App\Moldova\Entities\CompaniesEtenders;
use App\Moldova\Entities\Contracts;
use App\Moldova\Entities\CourtCases;
use App\Moldova\Entities\OcdsRelease;
use App\Moldova\Service\StringUtil;
use MongoDB\BSON\Regex;
use MongoRegex;

class ContractsRepository implements ContractsRepositoryInterface
{
    /**
     * @var Contracts
     */
    private $contracts;
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;
    /**
     * @var CompaniesDetail
     */
    private $contractors;
    /**
     * @var CourtCases
     */
    private $courtCases;

    /**
     * ContractsRepository constructor.
     *
     * @param Contracts       $contracts
     * @param CompaniesDetail $contractors
     * @param OcdsRelease     $ocdsRelease
     * @param CourtCases      $courtCases
     */
    public function __construct(Contracts $contracts, CompaniesDetail $contractors, OcdsRelease $ocdsRelease, CourtCases $courtCases)
    {
        $this->contracts   = $contracts;
        $this->ocdsRelease = $ocdsRelease;
        $this->contractors = $contractors;
        $this->courtCases  = $courtCases;
    }

    /**
     * {@inheritdoc}
     */
    public function getContractsByOpenYear()
    {
        $result = OcdsRelease::raw(
            function ($collection) {
                return $collection->aggregate(
                    [
                        [
                            '$unwind' => '$contracts',
                        ],
                        [
                            '$project' => [
                                "year"   => ['$year' => '$contracts.dateSigned'],
                                "id"     => '$id',
                                "amount" => '$contracts.value.amount',
                            ],
                        ],
                        [
                            '$group' => [
                                "_id"    => ["year" => '$year'],
                                'count'  => ['$sum' => 1],
                                "amount" => ['$sum' => '$amount'],
                            ],
                        ],
                    ]
                );
            }
        );

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getContractorsByOpenYear()
    {
        $result = OcdsRelease::raw(
            function ($collection) {
                return $collection->find(
                    [],
                    [
                        "buyer" => 1,
                    ]
                );
            }
        );

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcuringAgency($type, $limit, $year, $condition, $column)
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);


        $project = [
            '$project' => [
                "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                "buyer"  => '$buyer.name',
                "amount" => '$awards.value.amount',
            ],
        ];


        if ($column === 'awards.items.classification.description' || $column === 'awards.suppliers.name') {
            $match   = ['$match' => [$column => ['$in' => [$condition]]]];
            $project = [
                '$project' => [
                    "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                    "buyer"  => '$buyer.name',
                    "amount" => '$awards.value.amount',
                ],
            ];
            array_push($query, $match);
        }

        array_push($query, $project);

        $filter = ['$match' => ['year' => ['$gte' => (int) $year['from'], '$lte' => (int) $year['to']]]];
        array_push($query, $filter);

        $groupBy = [
            '$group' => [
                '_id'    => ['buyer' => '$buyer'],
                'count'  => ['$sum' => 1],
                'amount' => ['$sum' => '$amount'],
            ],
        ];
        array_push($query, $groupBy);

//        $filter = ['$match' => ['_id.year' => intval($year)]];


        $sort = ['$sort' => [$type => -1]];
        array_push($query, $sort);
        $limit = ['$limit' => $limit];
        array_push($query, $limit);

        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        );

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getContractors($type, $limit, $year, $condition, $column)
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);
        $project = [
            '$project' => [
                "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                "buyer"  => '$awards.suppliers.name',
                "amount" => '$awards.value.amount',
            ],
        ];


        if ($column === 'tender.procuringEntity.name' || $column === 'awards.items.classification.description') {
            $match   = ['$match' => [$column => ['$in' => [$condition]]]];
            $project = [
                '$project' => [
                    "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                    "buyer"  => '$awards.suppliers.name',
                    "amount" => '$awards.value.amount',
                ],
            ];
            array_push($query, $match);
        }

        array_push($query, $project);

        $filter = ['$match' => ['year' => ['$gte' => (int) $year['from'], '$lte' => (int) $year['to']]]];
        array_push($query, $filter);

        $groupBy = [
            '$group' => [
                '_id'    => ['buyer' => '$buyer', 'year' => '$year'],
                'count'  => ['$sum' => 1],
                'amount' => ['$sum' => '$amount'],
            ],
        ];
        array_push($query, $groupBy);

//        $filter = ['$match' => ['_id.year' => intval($year)]];
//        array_push($query, $filter);

        $sort = ['$sort' => [$type => -1]];
        array_push($query, $sort);
        $limit = ['$limit' => $limit];
        array_push($query, $limit);


        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        );

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalContractAmount()
    {
        $groupBy = [
            '$group' => [
                '_id'    => null,
                'amount' => ['$sum' => ['$sum' => '$contracts.value.amount']],
            ],
        ];

        $result = OcdsRelease::raw(
            function ($collection) use ($groupBy) {
                return $collection->aggregate([$groupBy]);
            }
        );

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getGoodsAndServices($type, $limit, $year, $condition, $column)
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);

        $project = [
            '$project' => [
                "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                "buyer"  => '$awards.items.classification.description',
                "amount" => '$awards.value.amount',
            ],
        ];

        if ($column === 'tender.procuringEntity.name' || $column === 'awards.suppliers.name') {
            $match   = ['$match' => [$column => ['$in' => [$condition]]]];
            $project = [
                '$project' => [
                    "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                    "buyer"  => '$awards.items.classification.description',
                    "amount" => '$awards.value.amount',
                ],
            ];
            array_push($query, $match);
        }

        array_push($query, $project);

        $filter = ['$match' => ['year' => ['$gte' => (int) $year['from'], '$lte' => (int) $year['to']]]];
        array_push($query, $filter);

        $groupBy = [
            '$group' => [
                '_id'    => ['buyer' => '$buyer', 'year' => '$year'],
                'count'  => ['$sum' => 1],
                'amount' => ['$sum' => '$amount'],
            ],
        ];
        array_push($query, $groupBy);

//        $filter = ['$match' => ['_id.year' => intval($year)]];
//        array_push($query, $filter);

        $sort = ['$sort' => [$type => -1]];
        array_push($query, $sort);
        $limit = ['$limit' => $limit];
        array_push($query, $limit);

        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        );

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getContractsList($params)
    {
        if ($params === "") {
            return $this->getContractsCount("");

        }

        $orderIndex = $params['order'][0]['column'];
        $ordDir     = $params['order'][0]['dir'];
        $column     = $this->getColumn($params['columns'][$orderIndex]['data']);
        $startFrom  = (int) $params['start'];
        $ordDir     = (strtolower($ordDir) == 'asc') ? 1 : -1;
        $search     = $params['search']['value'];

        $result = $this->contracts->where(
            function ($query) use ($search) {

                if (!empty($search)) {
                    return $query->where('goods.mdValue', 'like', '%'.$search.'%');
                }

                return $query;
            }
        )->take((int) $params['length'])->skip($startFrom)->orderBy($column, $ordDir)->get(["contractNumber", "id", "contractDate", "finalDate", "amount", "goods.mdValue"]);

        return ($result);
    }

    protected function getColumn($column)
    {
        switch ($column) {
            case '5':
                $column = 'amount';
                break;
            case '4':
                $column = 'finalDate';
                break;
            case '3':
                $column = 'contractDate';
                break;
            case '2':
                $column = 'goods.mdValue';
                break;
            case '0':
                $column = 'contractNumber';
                break;
            default :
                break;
        }

        return $column;
    }

    /**
     * {@inheritdoc}
     */
    public function getContractorsList($params)
    {
        $orderIndex  = $params['order'][0]['column'];
        $ordDir      = $params['order'][0]['dir'];
        $column      = $params['columns'][$orderIndex]['data'];
        $startFrom   = $params['start'];
        $ordDir      = (strtolower($ordDir) == 'asc') ? 1 : -1;
        $search      = $params['search']['value'];
        $limitResult = $params['length'];

        $query  = [];
        $filter = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);

        if ($search != '') {
            $search = StringUtil::accentToRegex($search);
            $filter = [
                '$match' => ['awards.suppliers.name' => new Regex(".*$search.*", 'i')],
            ];
        }

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy = [
            '$group' => [
                '_id'    => '$awards.suppliers.name',
                'count'  => ['$sum' => 1],
                'scheme' => ['$addToSet' => '$awards.suppliers.additionalIdentifiers.scheme'],
            ],
        ];
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

    /**
     * {@inheritdoc}
     */
    public function getDetailInfo($parameter, $column)
    {
        if ($column === 'buyer.name') {
            return ($this->ocdsRelease->where($column, $parameter)->get());
        }

        $column = ($column === 'awards.suppliers.name') ? 'participant.fullName' : 'goods.mdValue';

        return ($this->contracts->where($column, $parameter)->get(['id', 'amount', 'contractDate', 'finalDate', 'contractNumber', 'status.mdValue', 'goods.mdValue']));
    }

    /**
     * {@inheritdoc}
     */
    public function getContractDetailById($contractId)
    {
        $result = $this->ocdsRelease->where('contracts.id', (int) $contractId)->project(['contracts.$' => 1, 'awards' => 1, 'tender.id' => 1, 'tender.title' => 1, 'buyer.name' => 1])->first();

        if (empty($result)) {
            return null;
        }

        $contract                    = ($result['contracts'][0]);
        $contract['tender_title']    = $result['tender']['title'];
        $contract['tender_id']       = $result['tender']['id'];
        $contract['procuringAgency'] = $result['buyer']['name'];

        foreach ($result['awards'] as $award) {
            if ($award['id'] === $contract['awardID']) {
                $contract['goods']      = (!empty($award['items'])) ? $award['items'][0]['classification']['description'] : "-";
                $contract['contractor'] = (!empty($award['suppliers'])) ? $award['suppliers'][0]['name'] : "-";
                break;
            }
        }

        return $contract;
    }

    protected function formatDate($dt)
    {
        $dt = explode('-', $dt);
        $dt = implode(".", $dt);

        return $dt;
    }

    /**
     * {@inheritdoc}
     */
    public function search($params)
    {

        $orderIndex  = $params['order'][0]['column'];
        $ordDir      = $params['order'][0]['dir'];
        $column      = $this->getColumn($params['columns'][$orderIndex]['data']);
        $startFrom   = $params['start'];
        $ordDir      = (strtolower($ordDir) == 'asc') ? 1 : -1;
        $search      = $params['search']['value'];
        $limitResult = $params['length'];

        $q          = (!empty($params['q'])) ? $params['q'] : '';
        $contractor = (!empty($params['contractor'])) ? $params['contractor'] : '';
        $agency     = (!empty($params['agency'])) ? $params['agency'] : '';
        $range      = (!empty($params['amount'])) ? explode("-", $params['amount']) : '';
        $goods      = (!empty($params['goods'])) ? $params['goods'] : '';
        $startDate  = (!empty($params['startDate'])) ? $params['startDate'] : '';// (!empty($search['startDate'])) ? $this->formatDate($search['startDate']) : '';
        $endDate    = (!empty($params['endDate'])) ? $params['endDate'] : '';//(!empty($search['endDate'])) ? $this->formatDate($search['endDate']) : '';

        if (!empty($q) || !empty($agency) || !empty($contractor) || !empty($params['amount']) || !empty($startDate) || !empty($endDate) || !empty($goods)) {

            $query   = [];
            $project = [
                '$project' => [
                    "syear"          => ['$year' => '$contractDate'],
                    "fyear"          => ['$year' => '$finalDate'],
                    "id"             => '$id',
                    "contractNumber" => '$contractNumber',
                    "tender"         => '$tender.tenderData.goodsDescr',
                    "agency"         => '$tender.stateOrg.orgName',
                    "contractDate"   => '$contractDate',
                    "finalDate"      => '$finalDate',
                    "amount"         => '$amount',
                    "goods"          => '$goods.mdValue',
                    'participant'    => '$participant.fullName',
                    'status'         => '$status.mdValue',
                ],
            ];
            array_push($query, $project);

            if (!empty($q)) {
                $search = StringUtil::accentToRegex($q);

                $match = [
                    '$match' => [
                        '$or' => [
                            ['goods' => new Regex(".*$search.*", 'i')],
                            ['participant' => new Regex(".*$search.*", 'i')],
                            ['agency' => new Regex(".*$search.*", 'i')],
                            ['contractDate' => new Regex(".*$search.*", 'i')],
                            ['finalDate' => new Regex(".*$search.*", 'i')],
                        ],
                    ],
                ];
                array_push($query, $match);
            }

            if (!empty($agency)) {
                $match = ['$match' => ['agency' => $agency]];
                array_push($query, $match);
            }
            if (!empty($goods)) {
                $match = ['$match' => ['goods' => $goods]];
                array_push($query, $match);
            }

            if (!empty($contractor)) {
                $match = ['$match' => ['participant' => $contractor]];
                array_push($query, $match);
            }
            if (!empty($params['amount']) && $range[1] != 'Above') {
                $range[0] = (int) $range[0];
                $range[1] = (int) $range[1];

                $match = ['$match' => ['amount' => ['$gte' => $range[0], '$lte' => $range[1]]]];
                array_push($query, $match);
            } elseif (!empty($params['amount']) && $range[1] === 'Above') {
                $match = ['$match' => ['amount' => ['$gte' => (int) $range[0]]]];
                array_push($query, $match);
            }

            if (!empty($startDate)) {
                $match = ['$match' => ['syear' => ['$gte' => (int) $startDate]]];
                array_push($query, $match);
            }

            if (!empty($endDate)) {
                $match = ['$match' => ['syear' => ['$lte' => (int) $endDate]]];
                array_push($query, $match);
            }

            $sort = ['$sort' => [$column => $ordDir]];
            array_push($query, $sort);
            $skip = ['$skip' => (int) $startFrom];
            array_push($query, $skip);
            $limit = ['$limit' => (int) $limitResult];
            array_push($query, $limit);

            $res = Contracts::raw(
                function ($collection) use ($query) {
                    return $collection->aggregate($query);
                }
            );

            return ($res);

        }

        return [];
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function searchCount($params)
    {

        $q          = (!empty($params['q'])) ? $params['q'] : '';
        $contractor = (!empty($params['contractor'])) ? $params['contractor'] : '';
        $agency     = (!empty($params['agency'])) ? $params['agency'] : '';
        $range      = (!empty($params['amount'])) ? explode("-", $params['amount']) : '';
        $goods      = (!empty($params['goods'])) ? $params['goods'] : '';
        $startDate  = (!empty($params['startDate'])) ? $params['startDate'] : '';// (!empty($search['startDate'])) ? $this->formatDate($search['startDate']) : '';
        $endDate    = (!empty($params['endDate'])) ? $params['endDate'] : '';//(!empty($search['endDate'])) ? $this->formatDate($search['endDate']) : '';
        $query      = [];
        $project    = [
            '$project' => [
                "syear"          => ['$year' => '$contractDate'],
                "fyear"          => ['$year' => '$finalDate'],
                "id"             => '$id',
                "contractNumber" => '$contractNumber',
                "tender"         => '$tender.tenderData.goodsDescr',
                "agency"         => '$tender.stateOrg.orgName',
                "contractDate"   => '$contractDate',
                "finalDate"      => '$finalDate',
                "amount"         => '$amount',
                "goods"          => '$goods.mdValue',
                'participant'    => '$participant.fullName',
                'status'         => '$status.mdValue',
            ],
        ];
        array_push($query, $project);

        if (!empty($params['q'])) {
            $search = StringUtil::accentToRegex($q);

            $match = [
                '$match' => [
                    '$or' => [
                        ['goods' => new Regex(".*$search.*", 'i')],
                        ['participant' => new Regex(".*$search.*", 'i')],
                        ['agency' => new Regex(".*$search.*", 'i')],
                        ['contractDate' => new Regex(".*$search.*", 'i')],
                        ['finalDate' => new Regex(".*$search.*", 'i')],
                    ],
                ],
            ];
            array_push($query, $match);
        }

        if (!empty($agency)) {
            $match = ['$match' => ['agency' => $agency]];
            array_push($query, $match);
        }
        if (!empty($goods)) {
            $match = ['$match' => ['goods' => $goods]];
            array_push($query, $match);
        }

        if (!empty($contractor)) {
            $match = ['$match' => ['participant' => $contractor]];
            array_push($query, $match);
        }
        if (!empty($params['amount']) && $range[1] != 'Above') {
            $range[0] = (int) $range[0];
            $range[1] = (int) $range[1];

            $match = ['$match' => ['amount' => ['$gte' => $range[0], '$lte' => $range[1]]]];
            array_push($query, $match);
        } elseif (!empty($params['amount']) && $range[1] === 'Above') {
            $match = ['$match' => ['amount' => ['$gte' => (int) $range[0]]]];
            array_push($query, $match);
        }

        if (!empty($startDate)) {
            $match = ['$match' => ['syear' => ['$gte' => (int) $startDate]]];
            array_push($query, $match);
        }

        if (!empty($endDate)) {
            $match = ['$match' => ['syear' => ['$lte' => (int) $endDate]]];
            array_push($query, $match);
        }


        $res = Contracts::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        )->count();

        return ($res);

    }

    /**
     * {@inheritdoc}
     */
    public function getAllContractTitle()
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);
        $groupBy = [
            '$group' => [
                '_id'   => '$awards.suppliers.name',
                'count' => ['$sum' => 1],
            ],
        ];
        array_push($query, $groupBy);
        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        );

        return ($result);

    }

    /**
     * {@inheritdoc}
     */
    public function getContractDataForJson($contractId)
    {
        $result = OcdsRelease::raw(
            function ($collection) use ($contractId) {
                return $collection->find(['contracts.id' => (int) $contractId]);
            }
        );

        return ($result[0]);

//        return $this->ocdsRelease->where('contracts.id', (int) $contractId)->first();
    }

    public function getContractsCount($params)
    {
        $search = "";
        if ($params != "") {
            $search = $params['search']['value'];
        }

        $result = $this->contracts->where(
            function ($query) use ($search) {

                if (!empty($search)) {
                    return $query->where('goods.mdValue', 'like', '%'.$search.'%');
                }

                return $query;
            }
        )->count();

        return ($result);
    }

    public function getContractorsCount($params)
    {
        $search = "";
        if ($params != "") {
            $search = $params['search']['value'];
        }

        $query  = [];
        $filter = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);

        if ($search != '') {
            $search = StringUtil::accentToRegex($search);
            $filter = [
                '$match' => ['awards.suppliers.name' => new Regex(".*$search.*", 'i')],
            ];
        }

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy = [
            '$group' => [
                '_id' => '$awards.suppliers.name',
            ],
        ];
        array_push($query, $groupBy);

        $result = OcdsRelease::raw(
            function ($collection) use ($query) {
                return $collection->aggregate($query);
            }
        )->count();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyData($contractor)
    {
        return $this->contractors->where('cleanname', '=', $contractor)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getCourtCasesOfCompany($contractor)
    {
        return $this->courtCases->raw(
            function ($collection) use ($contractor) {
                return $collection->find(['clear_name' => $contractor], []);
            }
        );
//        return $this->courtCases->where('clear_name', '=', $contractor)->get();
    }

    public function getBlacklistCompany($contractor)
    {
        $blacklist = new Blacklist();

        return ($blacklist->where('clear_name', '=', $contractor)->first());
    }

    /**
     * @param $contractor
     *
     * @return mixed
     */
    public function getContractorClearName($contractor)
    {
//        $ar = ($this->ocdsRelease->raw(
//            function ($collection) use ($contractor) {
//                return $collection->find(['awards.suppliers.name' => $contractor], ['awards.suppliers.name' => 1, 'awards.suppliers.clearName' => 1]);
//            }
//        ));
//
//        foreach ($ar[0]['awards'] as $item) {
//            if ($item['suppliers'][0]['name'] === $contractor && isset($item['suppliers'][0]['clearName'])) {
//                return ($item['suppliers'][0]['clearName']);
//            }
//        }

        $companiesEtenders = new CompaniesEtenders();

        $contractor = $companiesEtenders->where('name', "=", $contractor)->first();

        return $contractor->cleanname;
    }

    /**
     * @param        $procuringAgency
     *
     * @param string $type
     *
     * @return mixed
     */
    public function getProcuringAgencyContractsByOpenYear($procuringAgency, $type = '')
    {

        if ($type === 'goods') {
            $get = '$awards.items.classification.description';
        } elseif ($type === 'buyer') {
            $get = '$buyer.name';
        } elseif ($type === 'contractor') {
            $get = '$awards.suppliers.name';
        }

        $result = OcdsRelease::raw(
            function ($collection) use ($procuringAgency, $get) {
                return $collection->aggregate(
                    [
                        [
                            '$unwind' => '$awards',
                        ],
                        [
                            '$project' => [
                                "year"   => ['$year' => '$awards.contractPeriod.startDate'],
                                "id"     => '$id',
                                "buyer"  => $get,
                                "amount" => '$awards.value.amount',
                            ],
                        ],
                        [
                            '$group' => [
                                "_id"    => ['buyer' => '$buyer', "year" => '$year'],
                                'count'  => ['$sum' => 1],
                                "amount" => ['$sum' => '$amount'],
                            ],
                        ],
                        [
                            '$match' => [
                                "_id.buyer" => $procuringAgency,
                            ],
                        ],
                    ]
                );
            }
        );

        return ($result);
    }
}
