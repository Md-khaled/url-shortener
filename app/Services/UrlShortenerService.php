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

    public function swapUrlToShortCode(array $urlData): string
    {
        $urlMapping = $this->urlMappingRepository->findByOriginalUrl($urlData->original_url);

        if ($urlMapping) {
            return $urlMapping->short_code;
        }

        return $this->urlMappingRepository->create($urlData->toArray())->short_code;
    }

    public function resolveShortCodeToUrl(string $shortCode): ?string
    {
        return $this->urlMappingRepository->findByShortCode($shortCode)->original_url;
    }
}
