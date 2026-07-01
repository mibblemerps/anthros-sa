<?php

use App\Http\Controllers\Api\AccessController;
use App\Http\Middleware\VerifyApiKeyMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware(VerifyApiKeyMiddleware::class)->group(function () {
    Route::post('/access', [AccessController::class, 'access']);

    Route::get('/ping', function () {
        return response('pong', Response::HTTP_OK)->header('Content-Type', 'text/plain');
    });
});
