<?php

namespace App\Http\Controllers\Admin;

use App\Moldova\Service\ContractorService;
use \Illuminate\Http\Request;
use App\Moldova\Service\Tenders;
use App\Http\Controllers\Controller;
use App\Moldova\Service\Dashboard;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{

    /**
     * @var Tenders
     */
    private $tenders;

    /**
     * @var ContractorService
     */
    private $contractor;

    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * DashboardController constructor.
     *
     * @param Tenders           $tenders
     * @param ContractorService $contractor
     * @param Dashboard         $dashboard
     */
    public function __construct(Tenders $tenders,ContractorService $contractor, Dashboard $dashboard)
    {
        $this->tenders = $tenders;
        $this->contractor = $contractor;
        $this->dashboard = $dashboard;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $last_imported_date = $this->dashboard->getLastImportDate();
        $last_company_import = $this->dashboard->getLastCompanyImportDate();
        $last_blacklist_import = $this->dashboard->getLastBlackListImportDate();
        $last_imported_days = date_diff(new \DateTime(), new \DateTime($last_imported_date))->days;
        $next_import_date   = date('Y-m-d', strtotime("+1 days"));
        $next_import_days   = 1;
        $total_rows         = $this->tenders->getTendersCount('');
        $import_running     = $this->dashboard->importStatus();
        $company_import_running     = $this->dashboard->companyImportStatus();

        return view('admin.dashboard', compact('last_imported_date','last_imported_days', 'next_import_date','last_company_import',
             'last_blacklist_import', 'next_import_days', 'total_rows', 'import_running', 'company_import_running'));
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function importData(Request $request){
        $status = $this->dashboard->importData();
        return $status == true ? 'true' : 'false';
    }

    /**
     * @param Request $request
     *
     * @return Response::json($array);
     */
    public function uploadCompanyExcel(Request $request){

        if($request->file('excel')->isValid() && $this->dashboard->validateCompanyExcel($request)){
            $status = $this->dashboard->runCompanyLinkage();
            return Response::json(array('code' => 200, 'message' => 'file uploaded'), 200);
        } else{
            return Response::json(array('code' => 401, 'message' => 'invalid file'),401);
        }
    }

    /**
     * @param Request $request
     *
     * @return Response::json($array);
     */
    public function uploadBlacklistExcel(Request $request){

        if($request->file('excel')->isValid() && $this->dashboard->validateBlacklistExcel($request)){
            $this->contractor->storeBlacklistData();
            $this->dashboard->runBlacklistImport();
            return Response::json(array('code' => 200, 'message' => 'file uploaded'), 200);
        } else{
            return Response::json(array('code' => 401, 'message' => 'invalid file'),401);
        }
    }
}
