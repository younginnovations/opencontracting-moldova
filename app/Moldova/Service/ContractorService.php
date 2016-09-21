<?php namespace App\Moldova\Service;

use App\Moldova\Entities\Blacklist;
use App\Moldova\Entities\CompanyFeedback;
use App\Moldova\Entities\Contractors;
use App\Moldova\Entities\CourtCases;
use App\Moldova\Repositories\Contracts\ContractsRepositoryInterface;
use GuzzleHttp\Client;


class ContractorService
{
    /**
     * @var ContractsRepositoryInterface
     */
    private $contracts;

    /**
     * ContractorService constructor.
     * @param ContractsRepositoryInterface $contracts
     */
    public function __construct(ContractsRepositoryInterface $contracts)
    {
        $this->reader    = new \SpreadsheetReader(public_path('newcompany.csv'));
        $this->contracts = $contracts;
    }

    /**
     * @return string
     */
    public function readExcel()
    {
        $this->reader->ChangeSheet(0);
        $keys = [];
        echo date('Y-m-d H:i:s');
        foreach ($this->reader as $key => $Row) {
            if ($key == 0) {
                $keys = $Row;
                continue;
            }
            $contractors = new Contractors();
            foreach ($Row as $i => $val) {
                $contractors->$keys[$i] = $val;
            }
            $contractors->save();
            echo $key . "\r\n";
        }
        echo date('Y-m-d H:i:s');

        return 'Finished Importing Data.....';
    }

    /**
     * @param $contractor
     * @return mixed
     */
    public function fetchInfo($contractor)
    {
        ini_set('memory_limit', '8192M');
//        $contractor  = 'A.I. NIKA-IMOBIL S.R.L.';
//        $contractor  = 'Deleu-Delev';

        $contractor  = $this->getTrimedCompanyName($contractor);
        $companyData = $this->contracts->getCompanyData($contractor);

//        if (sizeof($companyData) == 0) {
//            $companyData = [];
//            $contractor  = explode(" ", $contractor);
//
//            foreach ($contractor as $comp) {
//                if ($comp != 'S.R.L.' && !preg_match('![^a-z0-9]!i', $comp)) {
//                    $companyData = array_merge($this->contracts->getCompanyData($comp)->toArray(), $companyData);
//                }
//            }
//        }

        return $companyData;
    }

    /**
     * @param $contractor
     * @return String
     */
    private function getTrimedCompanyName($contractor)
    {
        $a    = "";
        $char = explode(" ", str_replace('"', '', $contractor));

        foreach ($char as $c) {

            if ($c != 'S.R.L.') {
                if (strpos($c, ".") == false) {
                    $a .= trim($c) . ' ';
                }
            }
//            else {
//                $a .= $c;
//            }
        }

        return str_replace('-', ' ', trim($a));
    }

    /**
     * API for fetching court cases of company
     * @return string
     */
    public function storeCourtData()
    {
        $client = new Client();
        $count  = $client->get('http://localhost:8081/getCasesCount');
        $offset = 0;
        $start  = date_create('Y-m-d H:i:s');

        for ($i = 0; $i <= $count->json() / 10000; $i ++) {
            $res = $client->get('http://localhost:8081/listCases/10000/' . $offset);

            foreach ($res->json() as $key => $courtData) {
                $courtCases = new CourtCases();
                $courtCases->create($courtData);
            }

            echo "#";
            $offset = $offset + 10000;
        }
        $end = date_create('Y-m-d H:i:s');

        return "Data imported successfully. It took " . date_diff($start, $end);

    }

    /**
     * @param $contractor
     * @return mixed
     */
    public function fetchCourtData($contractor)
    {
        $contractor = $this->getTrimedCompanyName($contractor);

        return ($this->contracts->getCourtCasesOfCompany($contractor));
    }

    /**
     * Reads the csv file of Company feedback and store to CompanyFeedback model.
     * @return string
     */
    public function storeFeedbackData()
    {
        $reader = new \SpreadsheetReader(public_path('feedback.csv'));
        $reader->ChangeSheet(0);
        $feedback = new CompanyFeedback();

        return $this->save($reader, $feedback, "Company Feedback");
    }

    /**
     * Reads the csv file of Company blacklist and store to Blacklist model.
     * @return string
     */
    public function storeBlacklistData()
    {
        $reader = new \SpreadsheetReader(public_path('blacklist.csv'));
        $reader->ChangeSheet(0);
        $blacklist = new Blacklist();

        return $this->save($reader, $blacklist, "Blacklist");
    }

    /**
     * @param $reader
     * @param $model
     * @param $title
     * @return string
     */
    protected function save($reader, $model, $title)
    {
        echo "Data import started";
        $start = date('Y-m-d H:i:s');

        foreach ($reader as $key => $Row) {
            if ($key == 0) {
                continue;
            }
            $data = [];
            foreach ($model->fillable as $index => $fill) {
                $data[$fill] = ("clear_name" != $fill) ? utf8_encode($Row[$index]) : "";
                $data['key'] = $key;
            }
            try {
                $model->create($data);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo "#";
        }

        $end = date('Y-m-d H:i:s');

        return 'Finished Importing ' . $title . ' Data within ' . $start . "=>" . $end;
    }
}
