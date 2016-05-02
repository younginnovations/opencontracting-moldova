<?php

namespace App\Moldova\Service;


use App\Moldova\Repositories\Subscriptions\SubscriptionsRepositoryInterface;

class Subscription
{
    /**
     * @var SubscriptionsRepositoryInterface
     */
    private $subscription;

    /**
     * ProcuringAgency constructor.
     * @param SubscriptionsRepositoryInterface $subscription
     */
    public function __construct(SubscriptionsRepositoryInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function addSubscriptions($input)
    {
        return $this->subscription->addSubscriptions($input);
    }

}