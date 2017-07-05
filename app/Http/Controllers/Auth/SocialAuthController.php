<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Moldova\Service\SocialAccount;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory;

/**
 * Class SocialAuthController
 * @package App\Http\Controllers\Auth
 */
class SocialAuthController extends Controller
{
    /**
     * @var Factory
     */
    protected $socialite;

    /**
     * @var SocialAccount
     */
    protected $socialAccount;

    /**
     * SocialAuthController constructor.
     *
     * @param Factory       $socialite
     * @param SocialAccount $socialAccount
     */
    public function __construct(Factory $socialite, SocialAccount $socialAccount)
    {
        $this->socialite     = $socialite;
        $this->socialAccount = $socialAccount;
    }

    /**
     * Redirect to facebook
     *
     * @param Request $request
     * @param string  $provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(Request $request, $provider)
    {
        $providerConfig = config("services.$provider");

        if (empty($providerConfig)) {
            return view('error_404');
        }

        if ($request->has('intended-url')) {
            session()->put('url.intended', $request->get('intended-url'));
        }

        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * Callback url to handle the user login from various social sites
     *
     * @param Request $request
     * @param string  $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request, $provider)
    {
        if (!$request->has('code')) {
            return redirect('/')->withError(sprintf('There was an error communication with %s', ucfirst($provider)));
        }

        $state = $request->get('state');
        $request->session()->put('state',$state);
        session()->regenerate();

        $user = $this->socialAccount->getOrCreateUser($this->socialite->driver($provider));
        auth()->login($user, true);

        return redirect()->intended('/');
    }
}
