<?php

use App\Http\Controllers\UrlShortenerController;
use Illuminate\Support\Facades\Route;

Route::post('/shorten', [UrlShortenerController::class, 'shortenUrl']);
Route::get('/{shortCode}', [UrlShortenerController::class, 'resolveUrl']);
Route::get('/url/list', [UrlShortenerController::class, 'shortUrlList']);
