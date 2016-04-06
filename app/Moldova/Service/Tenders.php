<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\Tenders\TendersRepositoryInterface;

class Tenders
{
    protected $tender;

    public function __construct(TendersRepositoryInterface $tender)
    {
        $this->tender = $tender;
    }

    /**
     * @return array
     */
    public function getTendersByOpenYear()
    {
        return $this->filterByYear($this->tender->getTendersByOpenYear());

    }

    /**
     * @param $tenders
     * @return array
     */
    protected function filterByYear($tenders)
    {
        $tenderByOpenYear = [];

        foreach ($tenders as $tender) {
            $year = explode(".", $tender['refTendeOpenDate']);

            if (array_key_exists($year[2], $tenderByOpenYear)) {
                $tenderByOpenYear[$year[2]] += 1;
            } else {
                $tenderByOpenYear[$year[2]] = 1;
            }

        }

        return $tenderByOpenYear;
    }

    /**
     * @param $procuringAgency
     * @return array
     */
    public function getProcuringAgencyTenderByOpenYear($procuringAgency)
    {
        return $this->filterByYear($this->tender->getProcuringAgencyTenderByOpenYear($procuringAgency));
    }

}
