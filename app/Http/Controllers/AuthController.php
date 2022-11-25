<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Attempt to authenticate using the provided credential
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if ($user = User::query()->firstWhere("phone_number", "=", $request->phoneNumber)) {
                $token = JWTAuth::fromUser($user);
                JWTAuth::setToken($token)->toUser();

                return response()->json([
                    "status" => true,
                    "message" => "Login successful",
                    "data" => compact(["user"]),
                    "error" => [],
                ])->withCookie(cookie(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"), $token, env("JWT_TTL", 120)));
            } else {
                try {
                    $user = self::signUp(new StoreUserRequest($request->all()));
                    $token = JWTAuth::fromUser($user);
                    JWTAuth::setToken($token)->toUser();
                    $userExists = false;

                    return response()->json([
                        "status" => true,
                        "message" => "Sign up successful",
                        "data" => compact(["user", "userExists"]),
                        "error" => [],
                    ])->withCookie(cookie(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"), $token, env("JWT_TTL", 120)));
                } catch (Exception $e) {
                    Log::error($e);
                    return response()->json([
                        "status" => false,
                        "message" => "Error creating user",
                        "data" => [],
                        "error" => $e->getCode(),
                    ]);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Login failed",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }

    /**
     * Sign up a user using a phone number
     * @throws Exception
     */
    public function signUp(StoreUserRequest $request): Builder|Model|JsonResponse
    {
        $request->merge([
            "role_id" => 1,
            "created_by" => 1,
            "updated_by" => 1,
        ]);
        Log::debug($request);

        return User::query()->create($request->all());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = User::query()->firstWhere("phone_number", "=", $request->phoneNumber);
            $userExists = !is_null($user);
            return response()->json([
                "status" => true,
                "message" => "Login successful",
                "data" => compact(["user","userExists"]),
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error getting auth user",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            auth()->logout();
            return response()->json([
                "status" => true,
                'message' => 'Successfully logged out',
                "data" => [],
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error logging out",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        try {
            $token = auth()->refresh();
            return response()->json([
                "status" => true,
                'message' => 'Successfully refreshed token',
                "data" => compact(["token"]),
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error refreshing token",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }
}
