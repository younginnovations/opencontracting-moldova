<?php

namespace App\Moldova\Service;


use Illuminate\Http\Request;
use App\Jobs\CompanyLinkage;
use App\Jobs\ImportData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Moldova\Entities\Jobs;

use Symfony\Component\Process\Process;


class Dashboard
{

    /**
     * @var string
     */
    var $cacheKey;

    /**
     * @var Jobs
     */
    var $jobs;

    /**
     * Dashboard constructor.
     *
     * @param Jobs $jobs
     */
    public function __construct(Jobs $jobs)
    {
         $this->jobs = $jobs;
         $this->cacheKey = 'import-running';
    }

    /**
     * @return bool
     */
    public function importData()
    {
        if (!$this->importStatus()) {
            dispatch(new ImportData());

            return true;
        } else {
            Log::info('import already started');
            return false;
        }
    }

    /**
     * @return bool
     */
    public function runCompanyLinkage()
    {
        if (!$this->companyImportStatus()) {
            $job = (new CompanyLinkage())->onQueue('company');
            dispatch($job);
            return true;
        } else {
            Log::info('company queue already running');
            return false;
        }
    }

    /**
     * @return bool
     */
    public function runBlacklistImport()
    {
        $process = new Process('../db_dump/company/blacklist.sh');
        $process->run();
        Cache::forever('BLACKLIST_IMPORT', date('Y-m-d'));
    }

    /**
     * @return bool
     */
    public function importStatus()
    {
        $running = $this->jobs->where("queue", "=", "default")->count();
        return $running > 0;
    }

    /**
     * @return bool
     */
    public function companyImportStatus()
    {
        $running = $this->jobs->where("queue", "=", "company")->count();
        return $running > 0;
    }

    /**
     * @return bool
     */
    public function blacklistImportStatus()
    {
        $running = $this->jobs->where("queue", "=", "blacklist")->count();
        return $running > 0;
    }

    /**
     * @return bool
     */
    public function getLastImportDate(){
        return Cache::get('REFRESH_DATE', env('REFRESH_DATE'));
    }

    /**
     * @return bool
     */
    public function getLastCompanyImportDate(){
        return Cache::get('COMPANY_LINKAGE', null);
    }

    /**
     * @return bool
     */
    public function getLastBlackListImportDate(){
        return Cache::get('BLACKLIST_IMPORT', null);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function validateCompanyExcel(Request $request)
    {
        $request->excel->move('uploads','company.xlsx');
        $reader = new \SpreadsheetReader(public_path('uploads/company.xlsx'));
        $sheets = $reader->Sheets();

        /**
         * Check if RSUD sheet is there
         */
        if(!in_array('RSUD', $sheets)){
            return false;
        };

        $reader->ChangeSheet(0);

        $header = null;

        foreach ($reader as $key => $Row) {
            $header = $Row;
           break;
        }

        //check if there are more than 10 columns
        if(count($header) < 10) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function validateBlacklistExcel(Request $request)
    {
        $request->excel->move('uploads','blacklist.csv');

        return true;
    }
}
