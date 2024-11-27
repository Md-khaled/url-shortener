<?php

namespace App\Helpers;

const API_PREFIX = 'api';

if (!function_exists('api_prefix')) {
    function api_prefix(): string
    {
        return API_PREFIX;
    }
}
