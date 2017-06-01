<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\Contracts\ContractsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class Contracts
{
    /**
     * @var ContractsRepositoryInterface
     */
    private $contracts;

    /**
     * Contracts constructor.
     *
     * @param ContractsRepositoryInterface $contracts
     */
    public function __construct(ContractsRepositoryInterface $contracts)
    {
        $this->contracts = $contracts;
    }

    /**
     * @return array
     */
    public function getContractsByOpenYear()
    {
        return $this->aggregateContracts($this->contracts->getContractsByOpenYear());

    }

    /**
     * @return mixed
     */
    public function getContractorsByOpenYear()
    {
        return $this->contracts->getContractorsByOpenYear();

    }

    /**
     * @param        $contracts
     * @param string $type
     *
     * @return array
     */
    public function aggregateContracts($contracts, $type = '')
    {
        $contractsByOpenYear = [];


        foreach ($contracts as $contract) {
            if (isset($contract['_id']['year'])) {
                $year                       = $contract['_id']['year'];
                $contractsByOpenYear[$year] = ('amount' == $type) ? $contract['amount'] : $contract['count'];
            }
        }

        ksort($contractsByOpenYear);

        return $contractsByOpenYear;
    }

    /**
     * Get Procuring Agency by amount/count according to type and by limit given
     *
     * @param        $type
     * @param        $limit
     * @param        $year
     * @param string $condition
     * @param string $column
     *
     * @return mixed
     */
    public function getProcuringAgency($type, $limit, $year, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getProcuringAgency($type, $limit, $year, $condition, $column), $type);
    }

    /**
     * Get CompaniesDetail by amount/count according to type and by limit given
     *
     * @param        $type
     * @param        $limit
     * @param        $year
     * @param string $condition
     * @param string $column
     *
     * @return mixed
     */
    public function getContractors($type, $limit, $year, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getContractors($type, $limit, $year, $condition, $column), $type);
    }

    /**
     * Get Goods And Services by amount/count according to type and by limit given
     *
     * @param        $type
     * @param        $limit
     * @param string $condition
     * @param        $column
     *
     * @return mixed
     */
    public function getGoodsAndServices($type, $limit, $year, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getGoodsAndServices($type, $limit, $year, $condition, $column), $type);
    }

    /**
     * Gets total amount of Contracts
     * @return float
     */
    public function getTotalContractAmount()
    {
        $total = $this->contracts->getTotalContractAmount();

        return $total[0]['amount'];
    }

    /**
     * @param $year
     * @return mixed
     */
    public function getYearContractAmount($year)
    {
        $total = $this->contracts->getYearContractAmount($year);

        return $total[0];
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function getContractsList($params)
    {
        $tenders   = $this->contracts->getContractsList($params);
        $contracts = [];

        if ($params === "") {
            return $tenders;
        }

        foreach ($tenders as $key => $contract) {
            $contracts[$key] = [];
            array_push($contracts[$key], $contract['contractNumber']);
            array_push($contracts[$key], $contract['id']);
            array_push($contracts[$key], $contract['goods']['mdValue']);
            array_push($contracts[$key], $contract['contractDate']->toDateTime()->format('c'));
            array_push($contracts[$key], $contract['finalDate']->toDateTime()->format('c'));
            array_push($contracts[$key], $contract['amount']);
        }

        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $this->getContractsCount(""),
            "recordsFiltered" => $this->getContractsCount($params),
            'data'            => array_values($contracts)

        ];
    }

    /**
     * @param $params
     * @return int
     */
    public function getContractsCount($params){
        return $this->contracts->getContractsCount($params);
    }

    /**
     * @param $year
     * @return int
     */
    public function getYearContractorsCount($year)
    {
        return $this->contracts->getYearContractorsCount(($year));
    }

    /**
     * @return array
     */
    public function getEndingSoon(){
        return $this->contracts->getEndingSoon();
    }

    /**
     * @return array
     */
    public function getRecentlySigned(){
        return $this->contracts->getRecentlySigned();
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function getContractorsList($params)
    {
        return [
            'draw' => (int) $params['draw'],
            'recordsTotal' => $this->getContractorsCount(""),
            'recordsFiltered' => $this->getContractorsCount($params),
            'data' => $this->contracts->getContractorsList($params)
        ];
    }

    /**
     * Find Contractor or Procuring Agency Info according to params provided
     *
     * @param $parameter
     * @param $column
     *
     * @return mixed
     */
    public function getDetailInfo($parameter, $column)
    {
        return $this->contracts->getDetailInfo($parameter, $column);
    }

    /**
     * @param        $data
     * @param        $type
     *
     * @return string
     */
    public function encodeToJson($data, $type = '', $page = '')
    {
        $jsonData = [];

        foreach ($data as $key => $val) {
            if ($val) {

                $jsonData[$key]['name']  = ($page === 'view') ? $val['_id']['year'] : ('trend' == $type) ? $val['_id']['year'] : $val['_id']['buyer'];
                $jsonData[$key]['value'] = ('trend' == $type) ? $val['count'] : $val[$type];
            }
        }

        $jsonData = ($page === 'view') ? collect($jsonData)->sortBy('name')->toArray() : ('trend' == $type) ? collect($jsonData)->sortBy('name')->toArray() : collect($jsonData)->sortByDesc('value')
            ->toArray();
        $jsonData = array_values($jsonData);

        return json_encode($jsonData);
    }

    /**
     * @param $contractId
     *
     * @return mixed
     */
    public function getContractDetailById($contractId)
    {
        return $this->contracts->getContractDetailById($contractId);
    }

    /**
     * @param $search
     *
     * @return mixed
     */
    public function search($search)
    {
        return $this->contracts->search($search);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function searchCount($params)
    {
        return $this->contracts->searchCount($params);
    }

    /**
     * @return mixed
     */
    public function getAllContractTitle()
    {
        return $this->contracts->getAllContractTitle();
    }

    /**
     * @param $contractId
     *
     * @return mixed
     */
    public function getContractDataForJson($contractId)
    {
        $response                                        = $this->contracts->getContractDataForJson($contractId);
        $response['date']                                = $response['date']->toDateTime()->format('c');
        $response['tender']['tenderPeriod']['startDate'] = $response['tender']['tenderPeriod']['startDate']->toDateTime()->format('c');
        $response['tender']['tenderPeriod']['endDate']   = $response['tender']['tenderPeriod']['endDate']->toDateTime()->format('c');

        foreach ($response['awards'] as $key => $award) {
            $response['awards'][$key]['contractPeriod']['startDate'] = $award['contractPeriod']['startDate']->toDateTime()->format('c');
        }

        foreach ($response['contracts'] as $key => $contract) {
            $response['contracts'][$key]['period']['startDate'] = $contract['period']['startDate']->toDateTime()->format('c');
            $response['contracts'][$key]['dateSigned']          = $contract['dateSigned']->toDateTime()->format('c');
        }

        unset($response['_id']);

        return $response;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getContractorsCount($params)
    {
        return $this->contracts->getContractorsCount($params);
    }

    /**
     * @param        $procuringAgency
     *
     * @param string $type
     *
     * @return string
     */
    public function getProcuringAgencyContractsByOpenYear($procuringAgency, $type = '')
    {
        return $this->contracts->getProcuringAgencyContractsByOpenYear($procuringAgency, $type);
    }
}
