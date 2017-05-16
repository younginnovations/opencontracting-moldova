<?php

namespace App\Moldova\Service;


use App\Moldova\Entities\OcdsRelease;
use App\Moldova\Repositories\Goods\GoodsRepositoryInterface;

class Goods
{
    /**
     * @var GoodsRepositoryInterface
     */
    private $goods;

    /**
     * Goods constructor.
     *
     * @param GoodsRepositoryInterface $goods
     */
    public function __construct(GoodsRepositoryInterface $goods)
    {
        $this->goods = $goods;
    }

    /**
     * Get all Goods list
     *
     * @param $params
     *
     * @return mixed
     */
    public function getAllGoods($params)
    {
        $data = $this->goods->getAllGoods($params);

        $goods = [];
        $count = 0;

        if ($params === "" && !empty($data)) {
            return count($data);
        }

        if (!empty($data)) {
            foreach ($data as $key => $good) {
                $goods[$count] = [];
                array_push($goods[$count], (isset($good['_id'][0])) ? $good['_id'][0] : '-');
                array_push($goods[$count], (isset($good['cpv_value'][0][0])) ? $good['cpv_value'][0][0] : '-');
                array_push($goods[$count], (isset($good['unit'][0][0])) ? $good['unit'][0][0] : '-');
                $count++;
            }
        }

        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $this->getGoodsCount(""),
            "recordsFiltered" => $this->getGoodsCount($params),
            "data"            => array_values($goods),
        ];
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function getGoodsCount($params)
    {
        return $this->goods->getGoodsCount($params);
    }

    //to get list of all goods/services
    public function allGoods()
    {
        $query  = [];
        $unwind = [
            '$unwind' => '$awards',
        ];
        array_push($query, $unwind);
       $groupBy = [
            '$group' => [
                '_id'   => '$awards.items.classification.description',
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
}
