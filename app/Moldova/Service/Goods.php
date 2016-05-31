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
            return count($data[0]['goods']);
        }

        if (!empty($data)) {
            foreach ($data[0]['goods'] as $key => $good) {
                $goods[$count]['good']      = (!empty($good))?$good[0]:'-';
                $goods[$count]['cpv_value'] = (!empty($data[0]['cpv_value'][$key])) ? $data[0]['cpv_value'][$key][0] : '-';
                $goods[$count]['scheme']    = 'CPV';
                $count ++;
            }
        }

        return $goods;
    }
}
