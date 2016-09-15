<?php namespace App\Console\Commands;

use App\Moldova\Service\ContractorService;
use Illuminate\Console\Command;
class StoreCompanyInformation extends Command
{

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'store:companyInfo';
    /**
     * @var ContractorService
     */
    private $contractorService;

    /**
     * Create a new command instance
     * @param ContractorService $contractorService
     */
    public function __construct(ContractorService $contractorService)
    {
        parent::__construct();
        $this->contractorService = $contractorService;
    }

    /**
     * Execute the console command
     */
    public function handle()
    {
        $this->comment($this->contractorService->storeBlacklistData());
        $this->comment($this->contractorService->storeFeedbackData());
//        $this->comment($this->contractorService->storeCourtData());
//        $this->comment($this->contractorService->readExcel());
    }
}