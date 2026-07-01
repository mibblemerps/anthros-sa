<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization') ?? $request->query('apikey');

        if ($authorization === null) {
            return response('No API key provided', Response::HTTP_UNAUTHORIZED)->header('Content-Type', 'text/plain');
        }

        if (Str::startsWith(Str::lower($authorization), 'bearer ')) {
            $authorization = Str::substr($authorization, Str::length('bearer '));
        }

        Log::debug($authorization);

        if (Str::trim($authorization) !== config('app.api_key')) {
            return response('Invalid API key', Response::HTTP_UNAUTHORIZED)->header('Content-Type', 'text/plain');
        }

        return $next($request);
    }
}
