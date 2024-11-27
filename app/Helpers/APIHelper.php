<?php

namespace App\Helpers;

const API_PREFIX = 'api';

if (!function_exists('api_prefix')) {
    function api_prefix(): string
    {
        return API_PREFIX;
    }
}
if (!function_exists('short_code_generator')) {
    function short_code_generator(): ShortCodeGeneratorInterface
    {
        return config('generator.short_code_length') ?
            new ShortCodeGenerator() :
            new UlidShortCodeGenerator();
    }
}
