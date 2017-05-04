<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Http\Request;
use App\Moldova\Service\Tenders;
use App\Http\Controllers\Controller;
use App\Moldova\Service\Dashboard;

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

        return view('admin.dashboard', compact('last_imported_date','last_imported_days', 'next_import_date',
                                               'next_import_days', 'total_rows', 'import_running'));
    }

    public function importData(Request $request){
        $status = $this->dashboard->importData();
        return $status == true ? 'true' : 'false';
    }
}
