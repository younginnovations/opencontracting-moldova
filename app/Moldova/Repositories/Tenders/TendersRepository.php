<?php

namespace App\Moldova\Repositories\Tenders;


use App\Moldova\Entities\Tenders;

class TendersRepository implements TendersRepositoryInterface
{
    public function __construct(Tenders $tenders)
    {
        $this->tenders = $tenders;
    }

    /**
     * {@inheritdoc}
     */
    public function getTendersByOpenYear()
    {
        return $this->tenders->get();
    }
}
