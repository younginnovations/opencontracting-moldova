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
        $result = OcdsRelease::raw(function ($collection) {
            return $collection->find([], [
                    "tender.tenderPeriod.startDate" => 1,
                    "_id"                           => 1
                ]
            );
        });

        return $result;
    }

    public function getProcuringAgencyTenderByOpenYear($procuringAgency)
    {
        $result = OcdsRelease::raw(function ($collection) use ($procuringAgency) {
            return $collection->find(['tender.procuringAgency.name' => $procuringAgency], [
                    "tender.tenderPeriod.startDate" => 1,
                    "_id"                           => 1
                ]
            );
        });

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllTenders($params)
    {
        $orderIndex = $params['order'][0]['column'];
        $ordDir     = $params['order'][0]['dir'];
        $column     = $params['columns'][$orderIndex]['data'];
        $startFrom  = $params['start'];
        $ordDir     = (strtolower($ordDir) == 'asc') ? 1 : - 1;
        $search     = $params['search']['value'];

        return $this->ocdsRelease
            ->select(['tender'])
            ->where(function ($query) use ($search) {

                if (!empty($search)) {
                    return $query->where('tender.title', 'like', '%' . $search . '%');
                }

                return $query;
            })
            ->take($params['length'])
            ->skip($startFrom)
            ->orderBy($column, $ordDir)
            ->get();

    }

    /**
     * {@inheritdoc}
     */
    public function getTenderDetailByID($tenderID)
    {
        return ($this->ocdsRelease->where('tender.id', '=', (int) $tenderID)->first());
    }
}
