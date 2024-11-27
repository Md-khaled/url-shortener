<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_shorten_url_invalid_request()
    {
        $response = $this->postJson('/api/shorten', [
            'original_url' => 'invalid-url',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('original_url');
    }
}
