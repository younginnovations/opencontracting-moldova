<?php

namespace App\Moldova\Service;

use App\Jobs\ImportData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Moldova\Entities\Jobs;

class Dashboard
{

    var $cacheKey;
    var $jobs;

    public function __construct(Jobs $jobs)
    {
         $this->jobs = $jobs;
         $this->cacheKey = 'import-running';
    }

    public function importData()
    {
        $running = $this->jobs->count();
        if ($running == 0) {
            dispatch(new ImportData());
            return true;
        } else {
            Log::info('import already started');
            return false;
        }
    }

    public function importStatus(){
        $running = $this->jobs->count();
        return $running > 0;
    }

    public function getLastImportDate(){
        return Cache::get('REFRESH_DATE', env('REFRESH_DATE'));
    }
}
