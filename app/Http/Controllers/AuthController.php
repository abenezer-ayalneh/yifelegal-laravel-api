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
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class AuthController extends Controller
{
    /**
     * Sign up a user using a phone number
     * @throws Exception
     */
    public function signUp(StoreUserRequest $request): Builder|Model|JsonResponse
    {
        $request->merge([
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        $user = User::query()->create($request->all());
        try {
            $token = auth()->login($user);
            Cookie::queue(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"), $token, env("JWT_ACCESS_TOKEN_TTL", "1440"), '/', 'yifelegal.vercel.app', false, true);
            $userExists = false;

            return response()->json([
                "status" => true,
                "message" => "Sign up successful",
                "data" => compact(["user", "userExists"]),
                "error" => [],
            ]);
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

    /**
     * Attempt to authenticate using the provided credential
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (!self::validatePhoneNumber($request->phoneNumber)) {
                throw ValidationException::withMessages(["Please enter a valid phone number"]);
            }

            if ($user = User::query()->firstWhere("phone_number", "=", $request->phoneNumber)) {
                $token = auth()->login($user);
                Cookie::queue(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"), $token, env("JWT_ACCESS_TOKEN_TTL", "1440"), '/', 'yifelegal.vercel.app', false, true);
                $userExists = true;

                return response()->json([
                    "status" => true,
                    "message" => "Login successful",
                    "data" => compact(["user", "userExists"]),
                    "error" => [],
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Phone number not found",
                    "data" => [],
                    "error" => [],
                ]);
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
     * Validation for phone number
     */
    public function validatePhoneNumber($phoneNumber): bool
    {
        $pattern = '/^\+(?:[0-9] ?){6,14}[0-9]$/';
        if (preg_match($pattern, $phoneNumber)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the authenticated User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = User::query()->firstWhere("phone_number", "=", $request->phoneNumber);
            $userExists = !is_null($user);
            return response()->json([
                "status" => true,
                "message" => "Checking user successful",
                "data" => compact(["user", "userExists"]),
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error fetching user",
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
    public function logout(Request $request): JsonResponse
    {
        try {
            if ($request->hasCookie(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"))) {
                $expiredCookie = cookie()->forget(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"));
            }
            Cookie::queue($expiredCookie);
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
     * @return JsonResponse
     */
    public function refresh()
    {
        try {
            $token = auth()->refresh();
            Cookie::queue(env("JWT_TOKEN_NAME", "API_ACCESS_TOKEN"), $token, env("JWT_ACCESS_TOKEN_TTL", "1440"), '/', 'yifelegal.vercel.app', false, true);
            return response()->json([
                "status" => true,
                'message' => 'Successfully refreshed token',
                "data" => [],
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

    /**
     * Check if the token is valid or not
     * @param Request $request
     * @return JsonResponse
     */
    public function checkToken(Request $request): JsonResponse
    {
        try {
            $user = auth()->userOrFail();

            return response()->json([
                "status" => true,
                'message' => 'Successfully checked token',
                "data" => compact("user"),
                "error" => [],
            ]);
        } catch (UserNotDefinedException $e) {
            Log::error($e);
            return response()->json([
                "status" => true,
                "message" => "User not found",
                "data" => ["user" => null],
                "error" => $e->getCode(),
            ], 403);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error checking token",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }
}
