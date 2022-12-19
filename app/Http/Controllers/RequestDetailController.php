<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestDetailRequest;
use App\Http\Requests\UpdateRequestDetailRequest;
use App\Models\RequestDetail;

class RequestDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequestDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestDetail  $requestDetail
     * @return \Illuminate\Http\Response
     */
    public function show(RequestDetail $requestDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestDetail  $requestDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestDetail $requestDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequestDetailRequest  $request
     * @param  \App\Models\RequestDetail  $requestDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestDetailRequest $request, RequestDetail $requestDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestDetail  $requestDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestDetail $requestDetail)
    {
        //
    }
}
