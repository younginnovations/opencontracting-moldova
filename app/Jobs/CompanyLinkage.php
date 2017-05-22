<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Process\Process;

use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

class CompanyLinkage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Company details import started');
        $file = fopen(public_path("company-status.txt"),"w");
        $command = base_path('db_dump/company/companyDetails.sh');
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->start();
        while($process->isRunning()){
            $message = $process->getOutput();
            fwrite($file, $message);
            sleep(120);
        }
        Cache::forever('COMPANY_LINKAGE', date('Y-m-d'));
        Log::info($process->getOutput());
        fwrite($file, $process->getOutput());
        Log::info("Company details import completed");
    }
}
