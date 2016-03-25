<?php

namespace App\Moldova\Repositories\Tenders;


use App\Moldova\Entities\Tenders;

class TendersRepository implements TendersRepositoryInterface
{
    /**
     * TendersRepository constructor.
     * @param Tenders $tenders
     */
    public function __construct(Tenders $tenders)
    {
        $this->tenders = $tenders;
    }

    /**
     * {@inheritdoc}
     */
    public function getTendersByOpenYear()
    {
        $result = Tenders::raw(function ($collection) {
            return $collection->find([], [
                    "refTendeOpenDate" => 1,
                    "_id"              => 1
                ]
            );
        });

        return $result;
    }
}
