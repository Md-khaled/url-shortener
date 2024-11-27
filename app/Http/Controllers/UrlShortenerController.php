<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlValidateRequest;
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
            dd($exception->getMessage());
            Log::error($exception->getMessage());
            return $this->handleException($exception);
        }
    }

    public function resolveUrl(string $shortCode)
    {
        try {
            $originalUrl = $this->urlShortenerService->resolveShortCodeToUrl(Str::squish($shortCode));

            return redirect($originalUrl);
        } catch (\Throwable $exception) {
            return $this->handleException($exception);
        }
    }
}
