<?php

namespace App\Moldova\Service;


use App\Moldova\Entities\OcdsRelease;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamExporter
{
    /**
     * @var OcdsRelease
     */
    private $ocdsRelease;

    /**
     * StreamExporter constructor.
     *
     * @param OcdsRelease $ocdsRelease
     */
    public function __construct(OcdsRelease $ocdsRelease)
    {

        $this->ocdsRelease = $ocdsRelease;
    }

    /**
     * @param $value
     * @param $column
     *
     * @return StreamedResponse
     */
    public function getContractorDetailForExport($value, $column)
    {
        $data     = [];
        $response = new StreamedResponse(
            function () use ($data, $value, $column) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'id',
                        'title',
                        'description',
                        'status',
                        'goods',
                        'contractor',
                        'startDate',
                        'endDate',
                        'amount',
                    ]
                );
                $this->ocdsRelease->where($column, '=', $value)->project(['contracts' => 1, 'awards' => 1])->chunk(
                    400,
                    function ($contractors) use ($data, $handle) {
                        foreach ($contractors as $contractor) {
                            foreach ($contractor['contracts'] as $key => $contract) {
                                $data['id']          = $contract['id'];
                                $data['title']       = $contract['title'];
                                $data['description'] = $contract['description'];
                                $data['status']      = $contract['status'];
                                $data['goods']       = (!empty($contractor['awards'][0]['items'])) ? $contractor['awards'][0]['items'][0]['classification']['description'] : "-";
                                $data['contractor']  = (!empty($contractor['awards'][0]['suppliers'])) ? $contractor['awards'][0]['suppliers'][0]['name'] : "-";
                                $data['startDate']   = $contract['period']['startDate'];
                                $data['endDate']     = $contract['period']['endDate'];
                                $data['amount']      = $contract['value']['amount'];

                                fputcsv($handle, $data);
                            }
                        }
                    }
                );


                // Close the output stream
                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="export.csv"',
             ]
        );

        return ($response);
    }

    /**
     * @return StreamedResponse
     */
    public function getAllContracts()
    {
        $data = [];

        $response = new StreamedResponse(
            function () use ($data) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'id',
                        'title',
                        'description',
                        'status',
                        'goods',
                        'contractor',
                        'startDate',
                        'endDate',
                        'amount',
                    ]
                );

                OcdsRelease::chunk(
                    400,
                    function ($contracts) use ($data, $handle) {
                        foreach ($contracts as $key => $contract) {
                            foreach ($contract['contracts'] as $k => $c) {
                                $award = $this->getContractAward($c['awardID']);
                                //dd($award['award']);
                                $data['id']          = $c['id'];
                                $data['title']       = $c['title'];
                                $data['description'] = $c['description'];
                                $data['status']      = $c['status'];
                                $data['goods']       = (!empty($award['awards'][0]['items'])) ? $award['awards'][0]['items'][0]['classification']['description'] : "-";
                                $data['contractor']  = (!empty($award['awards'][0]['suppliers'])) ? $award['awards'][0]['suppliers'][0]['name'] : "-";
                                $data['startDate']   = $c['period']['startDate'];
                                $data['endDate']     = $c['period']['endDate'];
                                $data['amount']      = $c['value']['amount'];

                                fputcsv($handle, $data);
                            }

                        }
                    }
                );

                // Close the output stream
                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="contracts.csv"',
             ]
        );

        return ($response);
    }

    /**
     * @param $awardId
     *
     * @return mixed
     */
    protected function getContractAward($awardId)
    {
        return ($this->ocdsRelease->where('awards.id', $awardId)->project(['awards.suppliers' => 1, 'awards.items' => 1])->first());
    }

    /**
     * @return StreamedResponse
     */
    public function fetchGoods()
    {
        $data     = [];
        $response = new StreamedResponse(
            function () use ($data) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'id',
                        'goods_and_services',
                        'quantity',
                        'cpv_code',
                        'unit',
                    ]
                );

                OcdsRelease::distinct('awards.items.classifications.description')->select(['awards.items'])->chunk(
                    400,
                    function ($goods) use ($data, $handle) {
                        foreach ($goods as $good) {
                            foreach ($good['awards']['items'] as $item) {
                                $data['id']                 = $item['id'];
                                $data['goods_and_services'] = $item['classification']['description'];
                                //$data['description']        = $item['description'];
                                $data['quantity'] = $item['quantity'];
                                $data['cpv_code'] = $item['classification']['id'];
                                $data['unit']     = $item['unit']['name'];

                                fputcsv($handle, $data);
                            }

                        }
                    }
                );
                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="goods.csv"',
             ]
        );

        return $response;
    }

    /**
     * @return StreamedResponse
     */
    public function fetchAgencies()
    {
        $data     = [];
        $response = new StreamedResponse(
            function () use ($data) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'name',
                        'address',
                        'email',
                        'phone',
                        'url',
                    ]
                );
                $this->ocdsRelease->distinct('buyer.name')->chunk(
                    400,
                    function ($buyers) use ($data, $handle) {
                        foreach ($buyers as $buyer) {
                            $agency = $this->ocdsRelease->select(['buyer'])->where('buyer.name', '=', $buyer['buyer']['name'])->first();

                            $data['name']    = $agency['buyer']['name'];
                            $data['address'] = $agency['buyer']['address']['streetAddress'];
                            $data['email']   = $agency['buyer']['contactPoint']['email'];
                            $data['phone']   = $agency['buyer']['contactPoint']['telephone'];
                            $data['url']     = $agency['buyer']['contactPoint']['url'];

                            fputcsv($handle, $data);

                        }
                    }
                );

                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="procuring_agencies.csv"',
             ]
        );

        return $response;
    }

    /**
     * @return StreamedResponse
     */
    public function fetchContractors()
    {
        $data = [];

        $response = new StreamedResponse(
            function () use ($data) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'name',
                    ]
                );
                $this->ocdsRelease->distinct('awards.suppliers.name')->chunk(
                    400,
                    function ($contractors) use ($data, $handle) {

                        foreach ($contractors as $contractor) {
                            foreach ($contractor['awards'] as $sup) {
                                $data['name'] = $sup['suppliers'][0]['name'];
                                fputcsv($handle, $data);
                            }
                        }


                    }
                );

                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="contractors.csv"',
             ]
        );

        return $response;
    }

    /**
     * @return StreamedResponse
     */
    public function fetchTenders()
    {
        $data = [];

        $response = new StreamedResponse(
            function () use ($data) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'id',
                        'title',
                        'description',
                        'procuringAgency',
                        'status',
                        'procurementMethod',
                        'tender_start_date',
                        'tender_end_date',

                    ]
                );
                $this->ocdsRelease->chunk(
                    400,
                    function ($tenders) use ($data, $handle) {
                        foreach ($tenders as $tender) {
                            $data['id']                = $tender['tender']['id'];
                            $data['title']             = $tender['tender']['title'];
                            $data['description']       = $tender['tender']['description'];
                            $data['procuringAgency']   = $tender['tender']['procuringEntity']['name'];
                            $data['status']            = $tender['tender']['status'];
                            $data['procurementMethod'] = $tender['tender']['procurementMethod'];
                            $data['tender_start_date'] = $tender['tender']['tenderPeriod']['startDate'];
                            $data['tender_end_date']   = $tender['tender']['tenderPeriod']['endDate'];
                            fputcsv($handle, $data);
                        }

                    }
                );

                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="contractors.csv"',
             ]
        );

        return $response;
    }

    /**
     * @param $tenderId
     *
     * @return StreamedResponse
     */
    public function fetchTenderGoods($tenderId)
    {
        $data = [];

        $response = new StreamedResponse(
            function () use ($data, $tenderId) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'name',
                        'cpv_code',
                        'quantity',
                        'unit',
                    ]
                );

                $this->ocdsRelease->where('tender.id', '=', (int) $tenderId)->chunk(
                    400,
                    function ($tenders) use ($data, $handle) {
                        foreach ($tenders as $tender) {
                            foreach ($tender['tender']['items'] as $item) {
                                $data['name']     = $item['classification']['description'];
                                $data['cpv_code'] = $item['classification']['id'];
                                $data['quantity'] = $item['quantity'];
                                $data['unit']     = $item['unit']['name'];

                                fputcsv($handle, $data);
                            }
                        }
                    }
                );

                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="tender_goods.csv"',
             ]
        );

        return $response;
    }


    /**
     * @param $tenderId
     *
     * @return StreamedResponse
     */
    public function fetchTenderContracts($tenderId)
    {
        $data = [];

        $response = new StreamedResponse(
            function () use ($data, $tenderId) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'id',
                        'title',
                        'goods',
                        'contract_start_date',
                        'contract_end_date',
                        'amount',
                    ]
                );

                $this->ocdsRelease->where('tender.id', '=', (int) $tenderId)->chunk(
                    400,
                    function ($tenders) use ($data, $handle) {
                        foreach ($tenders as $tender) {
                            foreach ($tender['contracts'] as $key => $contract) {
                                $data['id']                  = $contract['id'];
                                $data['title']               = $contract['title'];
                                $data['goods']               = (!empty($tender['awards'][$key]['items'])) ? $tender['awards'][$key]['items'][0]['classification']['description'] : '-';
                                $data['contract_start_date'] = $contract['dateSigned'];
                                $data['contract_end_date']   = $contract['period']['endDate'];
                                $data['amount']              = $contract['value']['amount'];

                                fputcsv($handle, $data);
                            }
                        }
                    }
                );

                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="tender_contracts.csv"',
             ]
        );

        return $response;
    }

    public function exportSearch($contracts)
    {
        $data     = [];
        $response = new StreamedResponse(
            function () use ($data, $contracts) {
                set_time_limit(0);
                $handle = fopen('php://output', 'w');
                fputcsv(
                    $handle,
                    [
                        'id',
                        'title',
                        'goods',
                        'buyer',
                        'contractor',
                        'contract_start_date',
                        'contract_end_date',
                        'amount',
                    ]
                );
                foreach ($contracts as $contract) {

                    $data['id']                  = $contract['id'];
                    $data['title']               = $contract['contractNumber'].'-'.$contract['tender'];
                    $data['goods']               = (isset($contract['goods'])) ? $contract['goods'] : '-';
                    $data['buyer']               = $contract['agency'];
                    $data['contractor']          = $contract['participant'];
                    $data['contract_start_date'] = $contract['contractDate']->toDateTime()->format('c');
                    $data['contract_end_date']   = $contract['finalDate']->toDateTime()->format('c');
                    $data['amount']              = $contract['amount'];

                    fputcsv($handle, $data);

                }
                fclose($handle);
            }, 200, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="search_contracts.csv"',
             ]
        );

        return $response;
    }

}