<?php

namespace App\Actions\CodeGenerator;

use App\Contracts\ShortCodeGeneratorInterface;
use Illuminate\Support\Str;

final readonly class UlidShortCodeGenerator implements ShortCodeGeneratorInterface
{
    public function generate(?int $length = null): string
    {
        return Str::ulid()->toString();
    }
}
