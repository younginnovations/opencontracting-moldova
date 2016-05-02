<?php
namespace App\Moldova\Repositories\Subscriptions;


use App\Moldova\Entities\Subscriptions;

interface SubscriptionsRepositoryInterface
{
    /**
     * @param $input
     * @return mixed
     */
    public function addSubscriptions($input);

}