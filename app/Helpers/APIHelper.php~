<?php

namespace App\Helpers;

use App\Actions\CodeGenerator\ShortCodeGenerator;
use App\Actions\CodeGenerator\UlidShortCodeGenerator;

const API_PREFIX = 'api';

if (!function_exists('api_prefix')) {
    function api_prefix(): string
    {
        return API_PREFIX;
    }
}
if (!function_exists('short_code_generator')) {
    function short_code_generator(): string
    {
        return config('generator.short_code_length') ?
            app(ShortCodeGenerator::class)->generate() :
            app(UlidShortCodeGenerator::class)->generate();
    }
}
