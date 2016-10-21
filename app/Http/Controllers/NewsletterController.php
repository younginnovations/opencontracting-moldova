<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Moldova\Service\Newsletter;
use GuzzleHttp\Exception\RequestException;

class NewsletterController extends Controller {

    /**
     * @var Newsletter
     */
    private $newsletter;

    /**
     * NewsletterController constructor.
     *
     * @param Newsletter $newsletter
     */
    public function __construct(Newsletter $newsletter){
        $this->newsletter = $newsletter;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Request $request
     */
    public function getContentView(){
        return $this->newsletter->getContentView();
    }

    public function subscribeUser(Request $request){

        try{
            $this->newsletter->subscribeUser($request->get("email"));
            return response(["message"=>"Thank you for subscribing. Please confirm to receive updates."],200);
        }catch (RequestException $e){
            return response(["message"=>"Email already subscribed."],$e->getResponse()->getStatusCode());
        }
    }
}
?>

