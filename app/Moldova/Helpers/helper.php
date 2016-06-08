<?php

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
     *      * @param  string  $path
     *      * @return string
     *      */

    function config_path($path = '')
    {
        return base_path() . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

function getSearchExport()
{
    return app('request')->fullUrl().'&export=1';
}
