<?php

use Carbon\Carbon;

if (! function_exists('create_date')) {

    function create_date($date, $format = 'Y-m-d H:i:s')
    {
        return Carbon::createFromFormat($format, $date);
    }
}

if (! function_exists('token')) {

    function token()
    {
        $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, 5);
    }
}
if (! function_exists('shuffle_assoc')) {
    
    function shuffle_assoc($list) { 
        if (!is_array($list)) return $list; 
        $keys = array_keys($list); 
        shuffle($keys); 
        $random = array(); 
        foreach ($keys as $key) { 
            $random[$key] = $list[$key]; 
        }
        return $random; 
    } 
}
if (! function_exists('acak_opsi')) {

    function acak_opsi($list)
    {
        if (!is_array($list)) return $list; 
        $keys = array_keys($list); 
        shuffle($keys); 
        return $keys; 
    }
}