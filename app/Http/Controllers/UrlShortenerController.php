<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlValidateRequest;
use App\Responses\JSResponse;
use App\Services\UrlShortenerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function App\Helpers\short_code_generator;

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
            return JSResponse::error($exception->getMessage(), null, $exception->getCode());
        }
    }

    public function resolveUrl(string $shortCode)
    {
        try {
            $originalUrl = $this->urlShortenerService->resolveShortCodeToUrl(Str::squish($shortCode));

            return redirect($originalUrl);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return JSResponse::error('Short code not found', null, Response::HTTP_NOT_FOUND);
        }
    }

    public function shortUrlList()
    {
        return $this->urlShortenerService->shortUrlList();
    }
}
