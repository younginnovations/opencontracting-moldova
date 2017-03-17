<?php

namespace App\Moldova\Repositories\Goods;


interface GoodsRepositoryInterface
{

    /**
     * Fetch all goods list
     * @param $params
     * @return mixed
     */
    public function getAllGoods($params);

    /**
     * Get count of goods
     * @param $params
     *
     * @return mixed
     */
    public function getGoodsCount($params);
}
