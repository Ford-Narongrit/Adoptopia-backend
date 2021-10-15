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
use App\Http\Controllers\TradeController;
use App\Http\Controllers\DtaSugController;
use App\Http\Controllers\OtaSugController;

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

Route::put('/deposit' , [UserController::class , 'deposit']);

Route::put('/trade/sell/{id}', [TradeController::class, 'sell']);

Route::put('/adopt/transfer/{id}/{transfer_id}', [AdoptController::class, 'transfer']);

Route::put('/withdraw' , [UserController::class , 'withdraw']);

Route::put('/spend' , [UserController::class , 'withdraw']);

Route::put('/earn' , [UserController::class , 'earn']);

Route::put('/trade/close_sale/{id}', [TradeController::class, 'close_sale']);

Route::put('/adopt/transfer/{id}/{transfer_id}', [AdoptController::class, 'transfer']);

Route::apiResource('/payment-histories', PaymentHistoryController::class);

Route::apiResource('/adopt', AdoptController::class);

Route::apiResource('/category', CategoryController::class);

Route::apiResource('/trade', TradeController::class);

Route::apiResource('/dta-sug', DtaSugController::class);

Route::apiResource('/ota-sug', OtaSugController::class);

Route::post('/files/upload/{dir}', [UploadFileController::class, 'store']);

//Notification Route
Route::prefix('notification')->group(function () {
    Route::apiResource('', NotificationController::class);
    Route::put('updateStatus', [NotificationController::class , 'updateStatus']);
    Route::get('unseen', [NotificationController::class , 'unseen']);
    Route::get('seen', [NotificationController::class , 'seen']);
});

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
