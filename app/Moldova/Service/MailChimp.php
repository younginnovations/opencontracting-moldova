<?php
/**
 * Created by PhpStorm.
 * User: Bishal
 * Date: 10/21/16
 * Time: 2:44 PM
 */

namespace App\Moldova\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class MailChimp
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $auth;

    /**
     * @var mixed
     */
    private $base_uri;
    /**
     * MailChimp constructor.
     * @internal param Newsletter $newsletter
     */
    public function __construct()
    {
        $this->headers=['content-type'=>'application/json'];
        $this->auth=['apikey',env('MAILCHIMP_APIKEY')];
        $this->base_uri=env('MAILCHIMP_URL');

        $this->client = new Client([
            'base_uri' => $this->base_uri,
            'defaults'=>[
                'headers'=> ['content-type'=>'appslication/json'],
                'auth'=>['apikey'=>env('MAILCHIMP_APIKEY')],
                'timeout'  => 5.0
            ]
        ]);
    }


    /**
     * Create new campaign in MailChimp
     * @param $title
     * @param $subject /
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    public function createCampaign($title,$subject){

        $params = ['recipients'=>['list_id'=>env("MAILCHIMP_LIST_ID"),'type'=>'regular'],
            'type'=>'regular',
            "settings"=>[
            'subject_line'=>$subject,
            'title'=>$title,
            'reply_to'=>'moldova@yipl.com.np',
            'from_name'=>'Moldova PPA'
        ]];

        try{
            $res = $this->client->post($this->base_uri.'campaigns',['headers'=>$this->headers,
                'auth'=>$this->auth,
                'json'=>$params]);
            return $res->getBody();
        }catch (RequestException $e){
            throw $e;
        }
    }

    /**
     * Set content of campaign in MailChimp
     * @param string $campaignId
     * @param $body
     * @return \GuzzleHttp\Stream\StreamInterface|null
     */
    public function setContent($campaignId,$body){
        $params = ['html'=>$body];
        try{
            $res = $this->client->put($this->base_uri."campaigns/{$campaignId}/content",['headers'=>$this->headers,
                'auth'=>$this->auth,
                'json'=>$params]);
            return $res->getBody();
        }catch (RequestException $e){
            throw $e;
        }
    }

    /**
     * Send generated campaign to subscribers
     * @param string $campaignId
     * @return int
     */
    public function sendCampaign($campaignId){
        try{
            $res = $this->client->post($this->base_uri."campaigns/{$campaignId}/actions/send",[
                'auth'=>$this->auth]);
            return $res->getStatusCode();
        }catch (RequestException $e){
            throw $e;
        }
    }

    public function subscribeUser($email){
        $params=["email_address"=>$email,"status"=>"pending"];
        try{
            $res = $this->client->post($this->base_uri."lists/".env("MAILCHIMP_LIST_ID")."/members",
                                       ["headers"=>$this->headers,
                                        "auth"=>$this->auth,
                                        "json"=>$params]);
            return $res;
        }catch (RequestException $e){
            throw $e;
        }
    }
}
?>
