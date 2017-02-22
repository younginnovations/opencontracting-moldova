<?php namespace App\Moldova\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class LocalizationService
 * @package App\Http\Services
 */
class LocalizationService
{
    /**
     * @var
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @var string
     */
    protected $key = 'lang';
    protected $defaultLang = "en";

    /**
     * Get Language code
     *
     * @param null $lang
     * @return string
     */
    public function getLanguage($lang = null)
    {

        $availableLang = config('language');

        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            $browserLang   = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            if (!isset($_COOKIE[$this->key]) && array_key_exists($browserLang, $availableLang)) {
                $lang = $browserLang;
            }

        }

        if (is_null($lang)) {
            $lang = isset($_COOKIE[$this->key]) ? $_COOKIE[$this->key] : $this->defaultLang;
        }

        if ($this->isValidLangCode($lang)) {
            return $lang;
        }
        return $this->defaultLang;
    }

    /**
     * Set Language code
     *
     * @param $lang
     * @return Void
     */
    public function setLanguage($lang)
    {
        $lang = trim(strtolower($lang));

        app('translator')->setLocale($lang);

        setcookie($this->key, $lang, Carbon::now()->addYear(1)->timestamp, '/');
    }

    /**
     * Check for valid lang code
     *
     * @param $lang
     * @return string
     */
    public function isValidLangCode($lang)
    {
        $languages = config('app.language');

        if (array_key_exists(strtolower($lang), $languages)) {
            return true;
        }

        return false;
    }

    /**
     * Get Current Language Code
     *
     * @return string
     */
    public function getCurrentLang()
    {
        return app('translator')->getLocale();
    }

    public function getDirection()
    {
        $lang = $this->getCurrentLang();
        $info = config('language')[$lang];

        return $info['dir'];
    }
}