<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheHeaders
{
    public function handle(Request $request, Closure $next, $maxAge = 3600)
    {
        $response = $next($request);

        if ($request->isMethod('GET') && $response->isSuccessful()) {
            $response->headers->set('Cache-Control', "public, max-age={$maxAge}");
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + $maxAge));
        }

        return $response;
    }
}