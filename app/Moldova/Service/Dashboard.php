<?php

namespace App\Moldova\Service;

use Illuminate\Http\Request;
use App\Jobs\CompanyLinkage;
use App\Jobs\ImportData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Moldova\Entities\Jobs;

use Maatwebsite\Excel\Facades\Excel;

class Dashboard
{

    var $cacheKey;
    var $jobs;

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

    public function getLastImportDate(){
        return Cache::get('REFRESH_DATE', env('REFRESH_DATE'));
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
}
