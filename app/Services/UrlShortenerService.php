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
        $urlMapping = $this->urlMappingRepository->findByOriginalUrl($urlData['original_url']);

        if ($urlMapping) return $urlMapping->short_url;

        return $this->urlMappingRepository->create($urlData)->short_url;
    }

    public function resolveShortCodeToUrl(string $shortCode): ?string
    {
        return $this->urlMappingRepository->findByShortCode($shortCode)->original_url;
    }

    public function shortUrlList()
    {
        return $this->urlMappingRepository->urlShortList();
    }
}
