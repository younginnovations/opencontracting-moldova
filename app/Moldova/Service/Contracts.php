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
     * @return array
     */
    public function aggregateContracts($contracts, $type = '')
    {
        $contractsByOpenYear = [];
        foreach ($contracts as $tender) {
            foreach ((array) $tender['contracts'] as $contract) {
//                $year = explode(".", $contract['dateSigned']);
                $year = date("Y", strtotime($contract['dateSigned']));

                if (array_key_exists($year, $contractsByOpenYear)) {
                    $contractsByOpenYear[$year] += ('amount' == $type) ? $contract['value']['amount'] : 1;
                } else {
                    $contractsByOpenYear[$year] = ('amount' == $type) ? $contract['value']['amount'] : 1;
                }
            }
        }
        ksort($contractsByOpenYear);

        return $contractsByOpenYear;
    }

    /**
     * Get Procuring Agency by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param        $year
     * @param string $condition
     * @param string $column
     * @return mixed
     */
    public function getProcuringAgency($type, $limit, $year, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getProcuringAgency($type, $limit, $year, $condition, $column), $type);
    }

    /**
     * Get Contractors by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param        $year
     * @param string $condition
     * @param string $column
     * @return mixed
     */
    public function getContractors($type, $limit, $year, $condition = '', $column = '')
    {
        return $this->encodeToJson($this->contracts->getContractors($type, $limit, $year, $condition, $column), $type);
    }

    /**
     * Get Goods And Services by amount/count according to type and by limit given
     * @param        $type
     * @param        $limit
     * @param string $condition
     * @param        $column
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

        return $total['result'][0]['amount'];
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getContractsList($params)
    {
//        dd($params);
        $tenders = $this->contracts->getContractsList($params);
        $contracts = [];

        if ($params === "") {
            return $tenders;
        }

        foreach ($tenders as $key => $contract) {
            $contracts[$key] = [];
            array_push($contracts[$key], $contract['contractNumber']);
            array_push($contracts[$key], $contract['id']);
            array_push($contracts[$key], $contract['goods']['mdValue']);
            array_push($contracts[$key], $contract['contractDate']);
            array_push($contracts[$key], $contract['finalDate']);
            array_push($contracts[$key], $contract['amount']);
        }

        return [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => $this->contracts->getContractsList(""),
            "recordsFiltered" => $this->contracts->getContractsList(""),
            'data'            => array_values($contracts)
        ];
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getContractorsList($params)
    {
        return $this->contracts->getContractorsList($params);
    }

    /**
     * Find Contractor or Procuring Agency Info according to params provided
     * @param $parameter
     * @param $column
     * @return mixed
     */
    public function getDetailInfo($parameter, $column)
    {
        return $this->contracts->getDetailInfo($parameter, $column);
    }

    /**
     * @param        $data
     * @param        $type
     * @return string
     */
    public function encodeToJson($data, $type = '')
    {
        $jsonData = [];
        $count    = 0;
        $data     = ('trend' == $type) ? $data : $data['result'];

        ksort($data);

        foreach ($data as $key => $val) {
            $jsonData[$count]['name']  = ('trend' == $type) ? $key : $val['_id'];
            $jsonData[$count]['value'] = ('trend' == $type) ? $val : $val[$type];
            $count ++;
        }

        return json_encode($jsonData);
    }

    /**
     * @param $contractId
     * @return mixed
     */
    public function getContractDetailById($contractId)
    {
        return $this->contracts->getContractDetailById($contractId);
    }

    /**
     * @param $search
     * @return mixed
     */
    public function search($search)
    {
        return $this->contracts->search($search);
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
     * @return mixed
     */
    public function getContractDataForJson($contractId)
    {
        $response = $this->contracts->getContractDataForJson($contractId);
        unset($response['_id']);

        return $response;
    }

    public function getContractorsCount()
    {
        return $this->contracts->getContractorsCount();
    }
}
