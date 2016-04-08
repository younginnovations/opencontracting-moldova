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