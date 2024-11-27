<?php

namespace App\Actions\CodeGenerator;

use App\Services\CodeGenerator\ShortCodeGeneratorInterface;
use Illuminate\Support\Str;

final readonly class UlidShortCodeGenerator implements ShortCodeGeneratorInterface
{
    public function generate(): string
    {
        return Str::ulid()->toString();
    }
}
