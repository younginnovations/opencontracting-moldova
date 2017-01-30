<?php namespace App\Moldova\Repositories\Contracts;

use App\Moldova\Entities\Blacklist;
use App\Moldova\Entities\Contractors;
use App\Moldova\Entities\Contracts;
use App\Moldova\Entities\CourtCases;
use App\Moldova\Entities\OcdsRelease;
use App\Moldova\Service\StringUtil;
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
     * @var Contractors
     */
    private $contractors;
    /**
     * @var CourtCases
     */
    private $courtCases;

    /**
     * ContractsRepository constructor.
     * @param Contracts   $contracts
     * @param Contractors $contractors
     * @param OcdsRelease $ocdsRelease
     * @param CourtCases  $courtCases
     */
    public function __construct(Contracts $contracts, Contractors $contractors, OcdsRelease $ocdsRelease, CourtCases $courtCases)
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
        $result = OcdsRelease::raw(function ($collection) {
            return $collection->find([], [
                    "contracts.dateSigned" => 1,
                    "_id"                  => 1
                ]
            );
        });

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getContractorsByOpenYear()
    {
        $result = OcdsRelease::raw(function ($collection) {
            return $collection->find([], [
                    "buyer" => 1
                ]
            );
        });

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcuringAgency($type, $limit, $year, $condition, $column)
    {
        $query  = [];
        $filter = ['$match' => ['tender.tenderPeriod.startDate' => ['$regex' => (string) $year, '$options' => 'g']]];
        array_push($query, $filter);

        if ($condition !== '') {
            $filter = [
                '$match' => [
                    $column => $condition
                ]
            ];
        }

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy = [
            '$group' => [
                '_id'    => '$buyer.name',
                'count'  => ['$sum' => 1],
                'amount' => ['$sum' => ['$sum' => '$contracts.value.amount']]
            ]
        ];
        array_push($query, $groupBy);
        $sort = ['$sort' => [$type => - 1]];
        array_push($query, $sort);
        $limit = ['$limit' => $limit];
        array_push($query, $limit);
        $result = OcdsRelease::raw(function ($collection) use ($query) {
            return $collection->aggregate($query);
        });

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getContractors($type, $limit, $year, $condition, $column)
    {
        $query  = [];
        $filter = ['$match' => ['contracts.dateSigned' => ['$regex' => (string) $year, '$options' => 'g']]];
        array_push($query, $filter);
        if ($condition !== '') {
            $filter = [
                '$match' => [
                    $column => $condition
                ]
            ];
        }

        $unwind = [
            '$unwind' => '$awards'
        ];
        array_push($query, $unwind);

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy =
            [
                '$group' => [
                    '_id'    => '$awards.suppliers.name',
                    'count'  => ['$sum' => 1],
                    'amount' => ['$sum' => '$awards.value.amount']
                ]
            ];
        array_push($query, $groupBy);
        $sort = ['$sort' => [$type => - 1]];
        array_push($query, $sort);
        $limit = ['$limit' => $limit];
        array_push($query, $limit);
        $result = OcdsRelease::raw(function ($collection) use ($query) {
            return $collection->aggregate($query);
        });

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalContractAmount()
    {
        $groupBy =
            [
                '$group' => [
                    '_id'    => null,
                    'amount' => ['$sum' => ['$sum' => '$contracts.value.amount']]
                ]
            ];

        $result = OcdsRelease::raw(function ($collection) use ($groupBy) {
            return $collection->aggregate($groupBy);
        });

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getGoodsAndServices($type, $limit, $year, $condition, $column)
    {
        $query  = [];
        $filter = ['$match' => ['contracts.dateSigned' => ['$regex' => (string) $year, '$options' => 'g']]];
        array_push($query, $filter);

        if ($condition !== '') {
            $filter = [
                '$match' => [
                    $column => $condition
                ]
            ];
        }

        $unwind = [
            '$unwind' => '$awards'
        ];
        array_push($query, $unwind);

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy =
            [
                '$group' => [
                    '_id'    => '$awards.items.classification.description',
                    'count'  => ['$sum' => 1],
                    'amount' => ['$sum' => '$awards.value.amount']
                ]
            ];
        array_push($query, $groupBy);
        $sort = ['$sort' => [$type => - 1]];
        array_push($query, $sort);
        $limit = ['$limit' => $limit];
        array_push($query, $limit);

        $result = OcdsRelease::raw(function ($collection) use ($query) {
            return $collection->aggregate($query);
        });

        return ($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getContractsList($params)
    {
        if ($params === "") {
            return $this->getContractsCount();

        }

        $orderIndex = $params['order'][0]['column'];
        $ordDir     = $params['order'][0]['dir'];
        $column     = $this->getColumn($params['columns'][$orderIndex]['data']);
        $startFrom  = $params['start'];
        $ordDir     = (strtolower($ordDir) == 'asc') ? 1 : - 1;
        $search     = $params['search']['value'];

        $result = $this->contracts
            ->where(function ($query) use ($search) {

                if (!empty($search)) {
                    return $query->where('goods.mdValue', 'like', '%' . $search . '%');
                }

                return $query;
            })
            ->take($params['length'])
            ->skip($startFrom)
            ->orderBy($column, $ordDir)
            ->get(["contractNumber", "id", "contractDate", "finalDate", "amount", "goods.mdValue"]);

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
        $ordDir      = (strtolower($ordDir) == 'asc') ? 1 : - 1;
        $search      = $params['search']['value'];
        $limitResult = $params['length'];

        $query  = [];
        $filter = [];
        $unwind = [
            '$unwind' => '$awards'
        ];
        array_push($query, $unwind);

        if ($search != '') {
            $filter = [
                '$match' => ['awards.suppliers.name' => $search]
            ];
        }

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy =
            [
                '$group' => [
                    '_id'    => '$awards.suppliers.name',
                    'count'  => ['$sum' => 1],
                    'scheme' => ['$addToSet' => '$awards.suppliers.additionalIdentifiers.scheme'],
                ]
            ];
        array_push($query, $groupBy);
        $sort = ['$sort' => [$column => $ordDir]];
        array_push($query, $sort);
        $skip = ['$skip' => (int) $startFrom];
        array_push($query, $skip);
        $limit = ['$limit' => (int) $limitResult];
        array_push($query, $limit);

        $result = OcdsRelease::raw(function ($collection) use ($query) {
            return $collection->aggregate($query);
        });

        return ($result['result']);
    }

    /**
     * {@inheritdoc}
     */
    public function getDetailInfo($parameter, $column)
    {
        return ($this->ocdsRelease->where($column, $parameter)->project(['contracts' => 1, 'awards' => 1])->get());
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
    public function search($search)
    {
        $q          = (!empty($search['q'])) ? $search['q'] : '';
        $contractor = (!empty($search['contractor'])) ? $search['contractor'] : '';
        $agency     = (!empty($search['agency'])) ? $search['agency'] : '';
        $range      = (!empty($search['amount'])) ? explode("-", $search['amount']) : '';
        $startDate  = (!empty($search['startDate'])) ? $search['startDate'] : '';// (!empty($search['startDate'])) ? $this->formatDate($search['startDate']) : '';
        $endDate    = (!empty($search['endDate'])) ? $search['endDate'] : '';//(!empty($search['endDate'])) ? $this->formatDate($search['endDate']) : '';

        if (!empty($q)) {
            $search = StringUtil::accentToRegex($q);
            $query  = array('awards.items.classification.description' => new MongoRegex("/.*{$search}.*/i"));
            $query2 = array('awards.suppliers.name' => new MongoRegex("/.*{$search}.*/i"));
            $query3 = array('buyer.name' => new MongoRegex("/.*{$search}.*/i"));
            $query4 = array('contracts.dateSigned' => new MongoRegex("/.*{$search}.*/i"));
            $query5 = array('contracts.period.endDate' => new MongoRegex("/.*{$search}.*/i"));

            $cursor = OcdsRelease::raw(function ($collection) use ($query, $query2, $query3, $query4, $query5) {
                return $collection->find([
                    '$or' => [
                        $query,
                        $query2,
                        $query3,
                        $query4,
                        $query5
                    ]
                ]);
            });

            return ($cursor);
        }

        return ($this->ocdsRelease
            ->project(['contracts.id' => 1, 'contracts.title' => 1, 'contracts.dateSigned' => 1, 'contracts.status' => 1, 'contracts.period.endDate' => 1, 'contracts.value.amount' => 1, 'awards' => 1])
            ->where(function ($query) use ($contractor, $range, $agency, $search, $startDate, $endDate) {

                if (!empty($contractor)) {
                    $query->where('awards.suppliers.name', "=", $contractor);
                }

                if (!empty($agency)) {
                    $query->where('buyer.name', "=", $agency);
                }

                if (!empty($search['amount']) && $range[1] != 'Above') {
                    $range[0] = (int) $range[0];
                    $range[1] = (int) $range[1];
                    $query->whereBetween('contracts.value.amount', $range);
                }

                if (!empty($startDate)) {
                    $query->where('contracts.dateSigned', "like", $startDate . "-%");
                }

                if (!empty($endDate)) {
                    $query->where('contracts.period.endDate', "like", $endDate . '-%');
                }

                return $query;
            })->get());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllContractTitle()
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards'
        ];
        array_push($query, $unwind);
        $groupBy =
            [
                '$group' => [
                    '_id'   => '$awards.suppliers.name',
                    'count' => ['$sum' => 1]
                ]
            ];
        array_push($query, $groupBy);
        $result = OcdsRelease::raw(function ($collection) use ($query) {
            return $collection->aggregate($query);
        });

        return ($result['result']);

    }

    /**
     * {@inheritdoc}
     */
    public function getContractDataForJson($contractId)
    {
        return $this->ocdsRelease->where('contracts.id', (int) $contractId)->first();
    }

    private function getContractsCount()
    {
        $groupBy =
            [
                '$group' => [
                    '_id' => '$contracts.title'
                ]
            ];
        $result  = OcdsRelease::raw(function ($collection) use ($groupBy) {
            return $collection->aggregate($groupBy);
        });
        $total   = 0;

        foreach ($result['result'] as $item) {
            $total = $total + count($item['_id']);
        }

        return ($total);
    }

    public function getContractorsCount()
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards'
        ];
        array_push($query, $unwind);
        $groupBy =
            [
                '$group' => [
                    '_id'    => '$awards.suppliers.name',
                    'count'  => ['$sum' => 1],
                    'scheme' => ['$addToSet' => '$awards.suppliers.additionalIdentifiers.scheme'],
                ]
            ];

        array_push($query, $groupBy);
        $result = OcdsRelease::raw(function ($collection) use ($query) {
            return $collection->aggregate($query);
        });

        return (count($result['result']));
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyData($contractor)
    {
        return $this->contractors->where('clearName', '=', $contractor)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getCourtCasesOfCompany($contractor)
    {
        return $this->courtCases->raw(function ($collection) use ($contractor) {
            return $collection->find(['clear_name' => $contractor], []);
        });
//        return $this->courtCases->where('clear_name', '=', $contractor)->get();
    }

    public function getBlacklistCompany($contractor)
    {
        $blacklist = new Blacklist();

        return ($blacklist->where('clear_name', '=', $contractor)->first());
    }

    /**
     * @param $contractor
     * @return mixed
     */
    public function getContractorClearName($contractor)
    {
        $ar = ($this->ocdsRelease->raw(function ($collection) use ($contractor) {
            return $collection->find(['awards.suppliers.name' => $contractor], ['awards.suppliers.name' => 1, 'awards.suppliers.clearName' => 1]);
        }));

        foreach ($ar[0]['awards'] as $item) {
            if ($item['suppliers'][0]['name'] === $contractor && isset($item['suppliers'][0]['clearName'])) {
                return ($item['suppliers'][0]['clearName']);
            }
        }
        return $contractor;
    }
}
