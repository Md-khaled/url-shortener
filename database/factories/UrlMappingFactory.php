<?php

namespace Database\Factories;

use App\Models\UrlMapping;
use Illuminate\Database\Eloquent\Factories\Factory;
use function App\Helpers\short_code_generator;

class UrlMappingFactory extends Factory
{
    protected $model = UrlMapping::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url,
            'short_code' => short_code_generator(),
        ];
    }
}
