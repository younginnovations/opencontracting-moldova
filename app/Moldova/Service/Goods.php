<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\Goods\GoodsRepositoryInterface;

class Goods
{
    /**
     * @var GoodsRepositoryInterface
     */
    private $goods;

    /**
     * Goods constructor.
     * @param GoodsRepositoryInterface $goods
     */
    public function __construct(GoodsRepositoryInterface $goods)
    {
        $this->goods = $goods;
    }

    /**
     * Get all Goods list
     * @param $params
     * @return mixed
     */
    public function getAllGoods($params)
    {
        $data = $this->goods->getAllGoods($params);

        $goods = [];
        $count = 0;

        if ($params === "" && !empty($data)) {
            //dd($data[0]['goods']);
            return count($data);
        }

        if (!empty($data)) {
            foreach ($data as $key => $good) {
                $goods[$count]['good'] = (!empty($good)) ? $good['_id'][0] : '-';
                $goods[$count]['cpv_value'] = (!empty($good['cpv_value'][$key])) ? $good['cpv_value'][$key][0] : '-';
                $goods[$count]['scheme'] = (!empty($good['unit'][$key])) ? $good['unit'][$key][0] : '-';
                $count ++;
            }
        }

        return $goods;
    }
}
