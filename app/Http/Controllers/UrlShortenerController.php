<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlValidateReqest;
use App\Services\CodeGenerator\ShortCodeGenerator;
use App\Services\UrlShortenerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UrlShortenerController extends Controller
{
    public function __construct(
        private UrlShortenerService $urlShortenerService,
        private ShortCodeGenerator  $shortCodeGenerator
    )
    {
    }

    public function shortenUrl(UrlValidateReqest $request)
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
