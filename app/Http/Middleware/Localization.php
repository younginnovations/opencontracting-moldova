<?php namespace App\Http\Middleware;

use App\Moldova\Service\LocalizationService;
use Closure;

/**
 * Class Localization
 * @package App\Http\Middleware
 */
class Localization
{
    /**
     * @var LocalizationService
     */
    protected $localization;

    /**
     * @param LocalizationService $localization
     */
    public function __construct(LocalizationService $localization)
    {
        $this->localization = $localization;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $this->localization->getLanguage($request->input('lang'));
        $this->localization->setLanguage($lang);
        return $next($request);
    }

}
