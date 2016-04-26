<?php
/**
 * Created by PhpStorm.
 * User: aayush
 * Date: 4/21/16
 * Time: 3:47 PM
 */

namespace App\Moldova\Service;


class Email
{
    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->sendGrid = new \SendGrid(env('SENDGRID_USERNAME', 'username'), env('SENDGRID_PASSWORD', 'password'));
    }

    /**
     * @param $subject
     * @param $message
     * @param $toEmailId
     * @param $fromEmailId
     * @return Email
     */
    protected function makeEmail($subject, $message, $fromEmailId){
        $sendgrid = new \SendGrid(env('SENDGRID_USERNAME', 'username'), env('SENDGRID_PASSWORD', 'password'),array("turn_off_ssl_verification" => true));
        $email = new \SendGrid\Email();

        $email
            ->addTo('moldova@yipl.com.np')
            ->setFrom($fromEmailId)
            ->setSubject($subject)
            ->setHtml($message);
        $response = $sendgrid->sendEmail($email);
        return $response;
    }

    public function sendMessage($messageData)
    {
        if(!$this->sendGrid){
            return null;
        }

        if(!isset($messageData['id'])){
            $message = $messageData['fullname']. " has sent an email, <br /><br />".$messageData['message'];
        }
        else{
            $message = $messageData['fullname']. " has sent an email, <br /><br />".$messageData['message']."<br />Contract ID: ".$messageData['id']."<br />Contract Title: ".$messageData['title']."<br />URL : ".url('/contracts/')."/".$messageData['id'];
        }
        $emailFrom = $messageData['email'];
        $subject = "About Moldova OCDS";
        return $this->makeEmail($subject, $message, $emailFrom);
    }
}