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
            return count($data);
        }

        if (!empty($data)) {
            foreach ($data as $key => $good) {
                $goods[$count] = [];
                array_push($goods[$count], (!empty($good)) ? $good['_id'][0] : '-');
                array_push($goods[$count], (!empty($good['cpv_value'][0])) ? $good['cpv_value'][0][0] : '-');
                array_push($goods[$count], (!empty($good['unit'][0])) ? $good['unit'][0][0] : '-');
                $count ++;
            }
        }

        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => count($this->goods->getAllGoods("")),
            "recordsFiltered" => count($this->goods->getAllGoods("")),
            "data"            => array_values($goods)
        ];
    }
}
