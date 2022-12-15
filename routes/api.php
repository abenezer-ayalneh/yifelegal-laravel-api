<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
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
Route::post("signUp", [AuthController::class, "signUp"])->name("signUp");

// Protected routes
Route::middleware(["api","jwt"])->group(function () {
    Route::apiResources([
        "user" => UserController::class,
        "request" => RequestController::class,
    ]);

    Route::post("me",[AuthController::class,"me"])->name("Auth.me");
    Route::post("checkToken",[AuthController::class,"checkToken"])->name("Auth.checkToken");
    Route::post("logout",[AuthController::class,"logout"])->name("Auth.logout");
});
