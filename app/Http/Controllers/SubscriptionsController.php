<?php
namespace App\Http\Controllers;


use App\Moldova\Service\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    private $subscription;

    /**
     * SubscriptionsController constructor.
     * @param Subscriptions $subs
     */
    public function __construct(Subscription $subs)
    {

        $this->subscription = $subs;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {
        $input = $request->all();

        if ($this->subscription->addSubscriptions($input)) {
            return "true";
        }

        return "false";
    }
}