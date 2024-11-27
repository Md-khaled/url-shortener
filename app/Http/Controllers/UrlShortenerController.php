<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlValidateRequest;
use App\Services\UrlShortenerService;
use Illuminate\Support\Facades\Log;

class UrlShortenerController extends Controller
{
    public function __construct(
        private UrlShortenerService $urlShortenerService,
    )
    {
    }

    public function shortenUrl(UrlValidateRequest $request)
    {
        try {
            $shortCode = $this->urlShortenerService
                ->swapUrlToShortCode($request->only('original_url', 'short_code'));

            return response()->json([
                'short_url' => $shortCode,
            ]);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return $this->handleException($exception);
        }
    }

    public function resolveUrl(string $shortCode)
    {
        try {
            $originalUrl = $this->urlShortenerService->resolveShortCodeToUrl($shortCode);

            return redirect($originalUrl);
        } catch (\Throwable $exception) {
            return $this->handleException($exception);
        }
    }
}
