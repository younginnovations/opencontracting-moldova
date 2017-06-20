<?php

namespace App\Console;

use App\Console\Commands\SendNewsletter;
use App\Console\Commands\StoreCompanyInformation;
use App\Console\Commands\ImportData;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        SendNewsletter::class,
        StoreCompanyInformation::class,
        ImportData::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('newsletter:send')->monthly();
        $schedule->command('import:run')->daily();
    }
}
