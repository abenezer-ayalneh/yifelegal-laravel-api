<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Token;

class JWTAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $rawToken = $request->cookie(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"));
            $token = new Token($rawToken);

            $request->headers->add([
                'Authorization' => 'Bearer ' . $token
            ]);

            return $next($request);
        } catch (Exception $e) {
            Log::error($e);
            if ($e instanceof TokenExpiredException) {
                $freshToken = auth()->refresh();
                Cookie::queue(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"), $freshToken, env("JWT_ACCESS_TOKEN_TTL", 1440));

                return $next($request);
            } else {
                return response('Unauthorized.', 401);
            }
        }
    }
}
