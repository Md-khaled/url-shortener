<?php

namespace App\Http\Controllers;

use App\Services\CodeGenerator\ShortCodeGenerator;
use App\Services\UrlShortenerService;
use Illuminate\Http\Request;

class UrlShortenerController extends Controller
{
    public function __construct(
        private UrlShortenerService $urlShortenerService,
        private ShortCodeGenerator  $shortCodeGenerator
    )
    {
    }

    public function shorten(Request $request)
    {
        try {
            $shortCode = $this->urlShortenerService
                ->swapUrlToShortCode(
                    $request->mergeIfMissing([
                        $url = 'original_url' => $request->$url,
                        'short_code' => $this->shortCodeGenerator->generate(),
                    ])
                );

            return response()->json([
                'short_url' => url($shortCode),
            ]);
        } catch (\Throwable $exception) {
            return $this->handleException($exception);
        }
    }

    public function resolve(string $shortCode)
    {
        try {
            $originalUrl = $this->urlShortenerService->resolveShortCodeToUrl($shortCode);

            return redirect($originalUrl);
        } catch (\Throwable $exception) {
            return $this->handleException($exception);
        }
    }
}
