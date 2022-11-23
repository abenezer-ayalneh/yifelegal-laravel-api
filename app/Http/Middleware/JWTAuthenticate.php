<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
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
    public function handle(Request $request, Closure $next)
    {
        try {
            $rawToken = $request->cookie(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"));
            $token = new Token($rawToken);

            $request->headers->add([
                'Authorization' => 'Bearer ' . $token
            ]);

        } catch (Exception $e) {
            Log::error($e);
            if ($e instanceof TokenExpiredException) {
//                $freshToken = auth()->refresh();
                //TODO refresh token
            }
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
