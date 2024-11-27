<?php

namespace App\Actions\CodeGenerator;

use App\Contracts\ShortCodeGeneratorInterface;
use Illuminate\Support\Str;

readonly class ShortCodeGenerator implements ShortCodeGeneratorInterface
{
    private readonly int $SHORT_CODE_LENGTH;

    public function __construct()
    {
        $this->SHORT_CODE_LENGTH = config('generator.short_code_length');
    }

    public function generate(?int $length = null): string
    {
        return strtoupper(substr(time(), -4) . Str::random(($length ?? $this->SHORT_CODE_LENGTH) - 4));
    }
}
