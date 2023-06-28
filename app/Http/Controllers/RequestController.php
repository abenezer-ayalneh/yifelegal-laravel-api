<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Request;
use App\Models\RequestDetail;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $requests = Request::query()->with("detail")->orderByDesc("created_at")->get();

            return response()->json([
                "status" => true,
                "message" => "Successfully fetched requests",
                "data" => compact("requests"),
                "error" => [],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error fetching requests",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }
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
                    "is_request_for_others" => is_null($storeRequest->requestedFor),
                    "requested_for" => $storeRequest->requestedFor,
                    "requested_for_phone_number" => $storeRequest->requestedForPhoneNumber,
                    "created_by" => auth()->id(),
                    "updated_by" => auth()->id(),
                ]);

                foreach ($storeRequest->except(["requestedForPhoneNumber","requestedFor"]) as $attribute => $value) {
                    RequestDetail::query()->create([
                        "request_id" => $request->getAttribute("id"),
                        "attribute" => $attribute,
                        "value" => $value ?? "",
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
     * Fetch my requests with their detail
     *
     * @return JsonResponse
     */
    public function myRequests(): JsonResponse
    {
        try {
            $myRequests = RequestDetail::query()
                ->where("created_by", "=", auth()->id())
                ->selectRaw("
                    SUM(if(attribute = 'entity' and value = 'house',1,0)) as houseCount,
                    SUM(if(attribute = 'entity' and value = 'land',1,0)) as landCount,
                    SUM(if(attribute = 'entity' and value = 'commercial building',1,0)) as commercialBuildingCount,
                    SUM(if(attribute = 'entity' and value = 'guest house',1,0)) as guestHouseCount,
                    SUM(if(attribute = 'entity' and value = 'machinery and trucks',1,0)) as machineryAndTruckCount,
                    SUM(if(attribute = 'entity' and value = 'car',1,0)) as carCount,
                    SUM(if(attribute = 'entity' and value = 'whole building',1,0)) as wholeBuildingCount,
                    SUM(if(attribute = 'entity' and value = 'three wheeler',1,0)) as threeWheelerCount
                ")->get();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error fetching your requests",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully fetched your requests",
            "data" => compact("myRequests"),
            "error" => [],
        ]);
    }

    /**
     * Fetch my requests with the specified entity
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function myRequestWithEntity(\Illuminate\Http\Request $request): JsonResponse
    {
        try {
            $myRequests = Request::query()
                ->where("created_by", "=", auth()->id())
                ->whereHas("detail", function (Builder $detail) use ($request) {
                    $detail->where("attribute", "=", "entity")->where("value", "=", $request->entity);
                })->with("detail")
                ->get();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                "status" => false,
                "message" => "Error fetching your $request->entity requests",
                "data" => [],
                "error" => $e->getCode(),
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully fetched your $request->entity requests",
            "data" => compact("myRequests"),
            "error" => [],
        ]);
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
