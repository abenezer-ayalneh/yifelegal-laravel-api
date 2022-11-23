<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Free routes
Route::post("login", [AuthController::class, "login"])->name("login");

Route::middleware('api')->group(function () {
    Route::apiResources([
        "user" => UserController::class,
    ]);
});
