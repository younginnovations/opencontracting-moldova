<?php

namespace App\Http\Controllers\Admin;

use App\Moldova\Service\FeedbackService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * @var FeedbackService
     */
    private $feedback;

    /**
     * FeedbackController constructor.
     *
     * @param FeedbackService $feedback
     */
    public function __construct(FeedbackService $feedback)
    {
        $this->middleware('auth');
        $this->feedback = $feedback;
    }

    /**
     * Returns all the contracts that has feedback and comments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(!Auth::user()->admin){
            return redirect('/');
        }

        $contractsWithComments = $this->feedback->getContractWithFeedback();

        return view('admin.index', compact('contractsWithComments'));
    }
}
