<?php

namespace App\Moldova\Repositories\Tenders;


use App\Moldova\Entities\Tenders;

interface TendersRepositoryInterface
{

    /**
     * @return Tenders
     */
    public function getTendersByOpenYear();

    /**
     * @param $procuringAgency
     * @return mixed
     */
    public function getProcuringAgencyTenderByOpenYear($procuringAgency);

    /**
     * @param $params
     * @return mixed
     */
    public function getAllTenders($params);

    /**
     * @param $tenderID
     * @return mixed
     */
    public function getTenderDetailByID($tenderID);

    public function getTenderFeedback($ref);
}
