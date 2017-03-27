<?php

namespace App\Http\Controllers\Admin;

use Faker\Provider\cs_CZ\DateTime;
use \Illuminate\Http\Request;
use App\Moldova\Service\Tenders;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * @var Tenders
     */
    private $tenders;

    public function __construct(Tenders $tenders)
    {
        $this->tenders = $tenders;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $last_imported_date = getenv('REFRESH_DATE');
        $last_imported_days = date_diff(new \DateTime(), new \DateTime($last_imported_date))->days;
        $next_import_date   = date('Y-m-d', strtotime("+1 days"));
        $next_import_days   = 1;
        $total_rows         = $this->tenders->getTendersCount('');

        return view('admin.dashboard', compact('last_imported_date','last_imported_days', 'next_import_date',
                                               'next_import_days', 'total_rows'));
    }
}
