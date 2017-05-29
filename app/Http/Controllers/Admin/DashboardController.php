<?php

namespace App\Http\Controllers\Admin;

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
     * @var Dashboard
     */
    private $dashboard;

    public function __construct(Tenders $tenders, Dashboard $dashboard)
    {
        $this->tenders = $tenders;
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
        $last_imported_days = date_diff(new \DateTime(), new \DateTime($last_imported_date))->days;
        $next_import_date   = date('Y-m-d', strtotime("+1 days"));
        $next_import_days   = 1;
        $total_rows         = $this->tenders->getTendersCount('');
        $import_running     = $this->dashboard->importStatus();
        $company_import_running     = $this->dashboard->companyImportStatus();

        return view('admin.dashboard', compact('last_imported_date','last_imported_days', 'next_import_date',
                                               'next_import_days', 'total_rows', 'import_running', 'company_import_running'));
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
     * @return mixed
     */
    public function uploadCompanyExcel(Request $request){

        if($request->file('excel')->isValid() && $this->dashboard->validateCompanyExcel($request)){
            $status = $this->dashboard->runCompanyLinkage();
            return Response::json(array('code' => 200, 'message' => 'file uploaded'), 200);
        } else{
            return Response::json(array('code' => 401, 'message' => 'invalid file'),401);
        }
    }
}
