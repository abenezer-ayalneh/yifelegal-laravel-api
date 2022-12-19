<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Request;
use App\Models\RequestDetail;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequestRequest $storeRequest
     * @return JsonResponse
     */
    public function store(StoreRequestRequest $storeRequest): JsonResponse
    {
        try {
            DB::transaction(function () use ($storeRequest) {
                $request = Request::query()->create([
                    "created_by" => auth()->id(),
                    "updated_by" => auth()->id(),
                ]);

                foreach ($storeRequest->all() as $attribute => $value) {
                    RequestDetail::query()->create([
                        "request_id" => $request->getAttribute("id"),
                        "attribute" => $attribute,
                        "value" => $value,
                        "created_by" => auth()->id(),
                        "updated_by" => auth()->id(),
                    ]);
                }
            });

            return response()->json([
                "status" => true,
                "message" => "Request submitted successfully",
                "data" => [],
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error storing your request",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequestRequest $request
     * @param Request $request
     * @return Response
     */
    public function update(UpdateRequestRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
