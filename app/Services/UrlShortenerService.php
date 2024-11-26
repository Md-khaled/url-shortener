<?php

namespace App\Services;

use App\Repositories\UrlMappingRepository;

class UrlShortenerService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UrlMappingRepository $urlMappingRepository)
    {

    }

    public function swapUrlToShortCode(string $originalUrl): string
    {
        $urlMapping = $this->urlMappingRepository->findByOriginalUrl($originalUrl);

        if ($urlMapping) {
            return $urlMapping->short_code;
        }

        return $this->urlMappingRepository->create([
            'original_url' => $originalUrl,
            'short_code' => $this->generateShortCode(),
        ])->short_code;
    }

    public function resolveShortCodeToUrl(string $shortCode): ?string
    {
        return $this->urlMappingRepository->findByShortCode($shortCode)->original_url;
    }
}
