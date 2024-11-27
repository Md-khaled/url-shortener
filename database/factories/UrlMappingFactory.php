<?php

namespace Database\Factories;

use App\Models\UrlMapping;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlMappingFactory extends Factory
{
    protected $model = UrlMapping::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url,
            'short_code' => strtoupper($this->faker->lexify('??????')),
        ];
    }
}
