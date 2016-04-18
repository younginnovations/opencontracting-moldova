<?php

namespace App\Moldova\Repositories\Goods;


use App\Moldova\Entities\OcdsRelease;

class GoodsRepository implements GoodsRepositoryInterface
{
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;

    /**
     * GoodsRepository constructor.
     * @param OcdsRelease $ocdsRelease
     */
    public function __construct(OcdsRelease $ocdsRelease)
    {

        $this->ocdsRelease = $ocdsRelease;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllTenders($params)
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
            '$unwind' => '$tender.items'
        ];
        array_push($query, $unwind);

        if ($search != '') {
            $filter = [
                '$match' => ['tender.items.classification.description' => ['$gt' => $search]]
            ];
        }

        if (!empty($filter)) {
            array_push($query, $filter);
        }

        $groupBy =
            [
                '$group' => [
                    '_id'       => '$tender.items.classification.description',
                    'count'     => ['$sum' => 1],
                    'cpv_value' => ['$addToSet' => '$tender.items.classification.id'],
                    'unit'      => ['$addToSet' => '$tender.items.unit.name']
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


//        $agencies = $this->ocdsRelease
//            //->select(['buyer.name'])
//            ->where(function ($query) use ($search) {
//                if (!empty($search)) {
//                    return $query->where('buyer.name', 'like', '%' . $search . '%');
//                }
//
//                return $query;
//            })
//            //->skip($startFrom)
//            ->orderBy($column, $ordDir)
//            ->distinct()
//            ->get(['buyer.name']);
//        $agencies = ($agencies->splice($startFrom)->take($limitResult));
//
//        $buyers = [];
//        foreach ($agencies as $key => $agency) {
//
//            $buyer = $this->getBuyerDetails($agency[0]);
//
//            $buyers[$key]['buyer']          = $agency[0];
//            $buyers[$key]['tender']         = $buyer['tenderCount'];
//            $buyers[$key]['contract']       = $buyer['contractCount'];
//            $buyers[$key]['contract_value'] = $buyer['amount'];
//
//        }
//
//        return $buyers;
    }
}
