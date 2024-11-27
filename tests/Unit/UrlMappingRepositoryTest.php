<?php

namespace Tests\Unit;

use App\Models\UrlMapping;
use App\Repositories\UrlMappingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlMappingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UrlMappingRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UrlMappingRepository();
    }

    public function test_create_url_mapping()
    {
        $data = ['original_url' => 'https://example.com', 'short_code' => 'ABC123'];

        $urlMapping = $this->repository->create($data);

        $this->assertInstanceOf(UrlMapping::class, $urlMapping);
        $this->assertEquals('https://example.com', $urlMapping->original_url);
        $this->assertEquals('ABC123', $urlMapping->short_code);
    }

    public function test_find_by_short_code()
    {
        $mapping = UrlMapping::factory()->create(['short_code' => 'ABC123']);
        $foundMapping = $this->repository->findByShortCode('ABC123');

        $this->assertEquals($mapping->id, $foundMapping->id);
    }

    public function test_find_by_original_url()
    {
        $mapping = UrlMapping::factory()->create(['original_url' => 'https://example.com']);
        $foundMapping = $this->repository->findByOriginalUrl('https://example.com');

        $this->assertEquals($mapping->id, $foundMapping->id);
    }
}
