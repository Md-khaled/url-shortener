<?php

namespace App\Repositories;

use App\Models\UrlMapping;

class UrlMappingRepository
{
    public function findByShortCode(string $shortCode): ?UrlMapping
    {
        return UrlMapping::where('short_code', $shortCode)->first();
    }

    public function findByOriginalUrl(string $originalUrl): ?UrlMapping
    {
        return UrlMapping::where('original_url', $originalUrl)->first();
    }

    public function create(array $data): UrlMapping
    {
        return UrlMapping::create($data);
    }

    public function urlShortList()
    {
        return UrlMapping::select('original_url', 'short_code')->paginate(2);
    }
}
