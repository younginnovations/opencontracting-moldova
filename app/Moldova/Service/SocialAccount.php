<?php
namespace App\Moldova\Service;

use App\Moldova\Entities\Auth\SocialAccount as SocialAccountModel;
use App\User;
use Laravel\Socialite\Contracts\Provider;

class SocialAccount
{
    /**
     * @var SocialAccountModel
     */
    protected $socialAccount;

    /**
     * @var User
     */
    protected $user;

    /**
     * SocialAccount constructor.
     *
     * @param SocialAccountModel $socialAccount
     * @param User               $user
     */
    public function __construct(SocialAccountModel $socialAccount, User $user)
    {
        $this->socialAccount = $socialAccount;
        $this->user          = $user;
    }

    /**
     * Get the user using the provider user id. Create on if the user doesn't exist
     *
     * @param Provider $provider
     *
     * @return User
     *
     */
    public function getOrCreateUser(Provider $provider)
    {
        $providerUser = $provider->user();
        $providerName = strtolower(str_replace('Provider', '', class_basename($provider)));
        $account      = $this->socialAccount->whereProvider($providerName)
                                            ->whereProviderUserId($providerUser->getId())
                                            ->first();

        if ($account) {
            return $account->user;
        }

        $account = $this->socialAccount->newInstance(['provider_user_id' => $providerUser->getId(), 'provider' => $providerName,]);
        $user    = $this->user->whereEmail($providerUser->getEmail())->first();

        if (!$user) {
            $user = $this->user->create(['email' => $providerUser->getEmail(), 'name' => $providerUser->getName(),]);
        }

        $account->user()->associate($user);
        $account->save();

        return $user;
    }
}
