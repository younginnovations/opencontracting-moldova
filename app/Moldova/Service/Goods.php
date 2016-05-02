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
        return $this->goods->getAllGoods($params);
    }
}
