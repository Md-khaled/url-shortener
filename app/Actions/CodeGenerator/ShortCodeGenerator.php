<?php

namespace App\Actions\CodeGenerator;

use App\Contracts\ShortCodeGeneratorInterface;
use Illuminate\Support\Str;

readonly class ShortCodeGenerator implements ShortCodeGeneratorInterface
{
    private const RANDOM_DEFAULT_LENGTH = 16;
    private readonly int $SHORT_CODE_LENGTH;

    public function __construct()
    {
        $this->SHORT_CODE_LENGTH = env('SHORT_CODE_LENGTH', self::RANDOM_DEFAULT_LENGTH);
    }

    public function generate(?int $length = null): string
    {
        return Str::random($length ?? $this->SHORT_CODE_LENGTH);
    }
}
