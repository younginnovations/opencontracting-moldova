<?php

namespace App\Http\Controllers;

use App\Moldova\Service\Contracts;
use App\Moldova\Service\Tenders;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var Contracts
     */
    private $contracts;

    /**
     * ExampleController constructor.
     * @param Tenders   $tenders
     * @param Contracts $contracts
     */
    public function __construct(Tenders $tenders, Contracts $contracts)
    {
        $this->tenders   = $tenders;
        $this->contracts = $contracts;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalContractAmount = round($this->contracts->getTotalContractAmount());
        $tendersTrends       = $this->tenders->getTendersByOpenYear();
        $contractsTrends     = $this->contracts->getContractsByOpenYear();
        $trends              = $this->mergeContractAndTenderTrends($tendersTrends, $contractsTrends);
        $procuringAgency     = $this->contracts->getProcuringAgency('amount', 5);
        $contractors         = $this->contracts->getContractors('amount', 5);
        $goodsAndServices    = $this->contracts->getGoodsAndServices('amount', 5);
        // $contractsList       = $this->contracts->getContractsList(10);

        return view('index', compact('totalContractAmount', 'trends', 'procuringAgency', 'contractors', 'goodsAndServices'));
    }

    public function getdata(Request $request)
    {
        $input = $request->all();

        // return $input['columns'][$input['order'][0]['column']]['data'];
        //return $input['order'][0]['column'];
        return $this->contracts->getContractsList($input);

    }

    public function datatable()
    {
        return view('dataTable');
    }

    protected function mergeContractAndTenderTrends($tendersTrends, $contractsTrends)
    {
        $trends = [];
        $count  = 0;

        foreach ($tendersTrends as $key => $tender) {
            $trends[$count]['xValue'] = $key;
            $trends[$count]['chart1'] = $tender;
            $trends[$count]['chart2'] = $contractsTrends[$key];
            $count ++;
        }

        return json_encode($trends);
    }

    /**
     * API call to sort data by count or amount
     * @param Request $request
     * @return mixed
     */
    public function filter(Request $request)
    {
        $filterBy = $request->get('filter');
        $type     = $request->get('type');
        $dataFor  = ($request->get('dataFor')) ? $this->getColumnName($request->get('dataFor')) : '';
        $param    = ($request->get('param')) ? $request->get('param') : '';

        switch ($type) {
            case ('contractor'):
                $data = $this->contracts->getContractors($filterBy, 5, $param, $dataFor);
                break;
            case ('agency'):
                $data = $this->contracts->getProcuringAgency($filterBy, 5, $param, $dataFor);
                break;
            case ('goods'):
                $data = $this->contracts->getGoodsAndServices($filterBy, 5, $param, $dataFor);
                break;

        }

        return $data;
    }

    /**
     * Get column name to search for according to sort data
     * @param $type
     * @return string
     */
    protected function getColumnName($type)
    {
        $column = '';

        switch ($type) {
            case ('contractor'):
                $column = 'participant.fullName';
                break;
            case ('agency'):
                $column = 'tender.stateOrg.orgName';
                break;
            case ('goods'):
                $column = 'goods.mdValue';
                break;
        }

        return $column;
    }
}
