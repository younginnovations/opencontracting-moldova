<?php

namespace App\Moldova\Repositories\Subscriptions;


use App\Moldova\Entities\Subscriptions;

class SubscriptionsRepository implements SubscriptionsRepositoryInterface
{
    private $subscriptions;

    public function __construct(Subscriptions $subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriptions($input)
    {
        if ($this->subscriptions->where('email', '=', $input['email'])->first()) {
            return false;
        }
        $this->subscriptions->email = $input['email'];

        return $this->subscriptions->save();
    }


}