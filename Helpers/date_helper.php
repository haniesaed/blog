<?php

use Carbon\Carbon;

if (!function_exists("dateFormatter")) {
    function dateFormatter($date, $format = "Y-m-d")
    {
        return Carbon::parse($date)->format($format);
    }
}