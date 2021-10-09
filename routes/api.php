<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdoptController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\Api\PaymentHistoryController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TradeAdopController;
use App\Http\Controllers\TradeCoinController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/user', UserController::class);

Route::put('/user/deposit/{id}/{amount}' , [UserController::class , 'deposit']);

Route::put('/user/withdraw/{id}/{amount}' , [UserController::class , 'withdraw']);

Route::get('/user/notification/{id}' , [UserController::class , 'notification']);

Route::apiResource('/notification', NotificationController::class);

Route::apiResource('/payment-histories', PaymentHistoryController::class);

Route::apiResource('/adopt', AdoptController::class);

Route::apiResource('/category', CategoryController::class);

Route::apiResource('/trade-adop', TradeAdopController::class);

Route::apiResource('/trade-coin', TradeCoinController::class);
Route::apiResource('/dta-sug', DtaSug::class);

Route::post('/files/upload/{dir}', [UploadFileController::class, 'store']);

//Auth Route
Route::group([
    'middenware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('update', [AuthController::class, 'update']);
});
