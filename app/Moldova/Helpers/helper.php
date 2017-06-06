<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;


function getContractInfo($title, $returnValue)
{
    $title = explode(" ", $title);

    if ($returnValue === 'id') {
        return $title[0];
    }
    unset($title[0]);

    return implode(" ", $title);
}

if (!function_exists('config_path')) {
    /**
     *      * Get the configuration path.
     *      *
     *      * @param  string   $path
     *      * @return string
     *      */

    function config_path($path = '')
    {
        return base_path().DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Return the path to public dir
     *
     * @param null $path
     *
     * @return string
     */
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/'.$path), '/');
    }
}

function getSearchExport()
{
    return app('request')->fullUrl().'&export=1';
}

function getLocalLang()
{
    return app('translator')->getLocale();
}

function listFounders($founders)
{
    return implode(",", $founders);
}

/**
 * Convert mongo date to human readable date
 *
 * @param $mongoDate
 * @return string
 */
function mongoToDate($mongoDate) {
    $date = $mongoDate->toDateTime();
    $carbonDate = Carbon::instance($date);
    return $carbonDate->diffForHumans();
}