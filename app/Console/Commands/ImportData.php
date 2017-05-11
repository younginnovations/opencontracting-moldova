<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Moldova\Service\Dashboard;

/**
 * Class ImportData
 * @package App\Console\Commands
 */
class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data';

    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * Import Data from Server
     *
     * @param Dashboard $dashboard
     *
     * @internal param ImportData $importData
     */
    public function __construct(Dashboard $dashboard)
    {
        parent::__construct();
        $this->dashboard = $dashboard;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->dashboard->importData();
    }
}
