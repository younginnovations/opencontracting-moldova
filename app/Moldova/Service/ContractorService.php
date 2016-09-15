<?php namespace App\Moldova\Service;

use App\Moldova\Entities\Contractors;
use App\Moldova\Repositories\Contracts\ContractsRepositoryInterface;


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
}
