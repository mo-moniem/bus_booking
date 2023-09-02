<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SeatBookingController;
use App\Http\Controllers\AuthController;

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


Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('cities',CityController::class);
    Route::get('available/trip/seats',[SeatBookingController::class,'getAvailableTripSeat']);
    Route::post('trip/{trip}/seat',[SeatBookingController::class,'tripSeatBooking']);
});
