<?php

namespace App\Moldova\Repositories\Tenders;


use App\Moldova\Entities\OcdsRelease;
use App\Moldova\Entities\Tenders;

class TendersRepository implements TendersRepositoryInterface
{
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;

    /**
     * TendersRepository constructor.
     * @param Tenders     $tenders
     * @param OcdsRelease $ocdsRelease
     */
    public function __construct(Tenders $tenders, OcdsRelease $ocdsRelease)
    {
        $this->tenders     = $tenders;
        $this->ocdsRelease = $ocdsRelease;
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

    public function getProcuringAgencyTenderByOpenYear($procuringAgency)
    {
        $result = Tenders::raw(function ($collection) use ($procuringAgency) {
            return $collection->find(['stateOrg.orgName' => $procuringAgency], [
                    "refTendeOpenDate" => 1,
                    "_id"              => 1
                ]
            );
        });

        return $result;
    }

    /**
     * @return mixed
     */
    public function getAllTenders()
    {
        $result = $this->ocdsRelease->paginate(20, ['tender']);

        return $result;
    }

    /**
     * @param $tenderID
     * @return mixed
     */
    public function getTenderDetailByID($tenderID)
    {
        return ($this->ocdsRelease->where('tender.id','=',(int) $tenderID)->first());
    }
}
