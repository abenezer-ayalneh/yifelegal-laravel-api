<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserStatusUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $users = User::withTrashed()->get();
            return response()->json([
                "status" => true,
                "message" => "Successfully fetched users",
                "data" => compact("users"),
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error fetching users",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create($request->validated());
            $token = $user->createToken("userToken")->plainTextToken;
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error registering a user",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully registered",
            "data" => compact(["user", "token"]),
            "error" => [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param UserStatusUpdateRequest $request
     * @return JsonResponse
     */
    public function changeActiveStatus(UserStatusUpdateRequest $request): JsonResponse
    {
        try {
            $user = User::withTrashed()->find($request->userID);
            if ($request->status) {
                $user->update([
                    "deleted_at" => null,
                    "deleted_by" => null,
                ]);
            } else {
                $user->update([
                    "deleted_by" => auth()->id(),
                ]);
                $user->delete();
            }
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error changing active status of the user",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully changed user's status",
            "data" => compact("user"),
            "error" => [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        return $request->user();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
