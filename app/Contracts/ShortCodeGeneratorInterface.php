<?php

namespace App\Contracts;

interface ShortCodeGeneratorInterface
{
    public function generate(?int $length): string;
}
