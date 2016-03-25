<?php

namespace App\Moldova\Repositories\Tenders;


use App\Moldova\Entities\Tenders;

interface TendersRepositoryInterface
{

    /**
     * @return Tenders
     */
    public function getTendersByOpenYear();
}
