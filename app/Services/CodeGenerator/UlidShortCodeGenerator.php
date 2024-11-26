<?php

namespace App\Services\CodeGenerator;

use Illuminate\Support\Str;

final readonly class UlidShortCodeGenerator implements ShortCodeGeneratorInterface
{
    public function generate(): string
    {
        return Str::ulid()->toString();
    }
}
