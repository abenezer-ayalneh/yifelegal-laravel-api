<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------5
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Free routes

// Protected routes
Route::post("refresh", [AuthController::class, "refresh"])->name("Auth.refresh");
Route::middleware(["api"])->group(function () {
    // Auth
    Route::post("sign-up", [AuthController::class, "signUp"])->name("Auth.signUp");
    Route::post("login", [AuthController::class, "login"])->name("Auth.login");
    Route::post("me", [AuthController::class, "me"])->name("Auth.me");
    Route::post("check/token", [AuthController::class, "checkToken"])->name("Auth.checkToken");
    Route::post("logout", [AuthController::class, "logout"])->name("Auth.logout");

    // User
    Route::prefix("users")->group(function () {
        Route::get("/", [UserController::class, "index"])->name("User.index");

        Route::post("/store", [UserController::class, "store"])->name("User.store");
        Route::post("/changeActiveStatus", [UserController::class, "changeActiveStatus"])->name("User.changeActiveStatus");
    });

    // Request
    Route::prefix("request")->group(function () {
        Route::get("/", [RequestController::class, "index"])->name("Request.index");
        Route::get("mine", [RequestController::class, "myRequests"])->name("Request.myRequests");
        Route::get("mine/entity", [RequestController::class, "myRequestWithEntity"])->name("Request.myRequestWithEntity");

        Route::post("store", [RequestController::class, "store"])->name("Request.store");
    });

    // Payment
    Route::prefix("payment")->group(function () {
        Route::post('pay', [PaymentController::class, "initialize"])->name('Payment.pay');
        Route::get('callback/{reference}', [PaymentController::class, "callback"])->name('Payment.callback');
    });
});
