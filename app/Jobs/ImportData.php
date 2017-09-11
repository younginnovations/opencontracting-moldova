<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

class ImportData extends Job implements ShouldQueue
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
        Log::info('import started');
        $file = public_path("import-status.txt");
        $command = base_path('db_dump/run.sh');
        $process = new Process($command);
        $process->setTimeout(7200);
        $process->start();
        while($process->isRunning()){
            $message = $process->getOutput();
            $message = explode("\n", $message);
            $message = array_reverse($message);
            $message = implode($message, "\n");
            file_put_contents($file, $message);
            sleep(120);
        }
        Cache::forever('REFRESH_DATE', date('Y-m-d'));
        $message = $process->getOutput();
        $message = explode("\n", $message);
        $message = array_reverse($message);
        $message = implode($message, "\n");
        Log::info($message);
        file_put_contents($file, $message);

        //clear all cache after new data has been imported
        if (Cache::has('routes')) {
            $cache_array = array_unique(str_getcsv(Cache::get('routes')));
            foreach ($cache_array as $key) {
                if (Cache::has($key)) {
                    Cache::forget($key);
                }
            }
            Cache::forget('routes');
        }

        Log::info("import completed");
    }
}
