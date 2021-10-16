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

//user
Route::apiResource('/user', UserController::class);
Route::put('/deposit', [UserController::class, 'deposit']);
Route::put('/user/spend/{id}/{amount}', [UserController::class, 'spend']);
Route::put('/withdraw', [UserController::class, 'withdraw']);
Route::put('/spend', [UserController::class, 'withdraw']);
Route::put('/earn', [UserController::class, 'earn']);

//Adopt
Route::put('/adopt/transfer/{id}/{transfer_id}', [AdoptController::class, 'transfer']);
Route::put('/adopt/transfer/{id}/{transfer_id}', [AdoptController::class, 'transfer']);
Route::get('/adops/{slug}', [AdoptController::class, 'getAllUserAdop']);
Route::apiResource('/adopt', AdoptController::class);
Route::put('/adopt/transfer/{id}/{transfer_id}', [AdoptController::class, 'transfer']);

//Trade
Route::put('/trade/sell/{id}', [TradeController::class, 'sell']);
Route::put('/trade/sell/{id}', [TradeController::class, 'sell']);
Route::put('/trade/close_sale/{id}', [TradeController::class, 'close_sale']);
Route::apiResource('/trade', TradeController::class);

//Other
Route::apiResource('/payment-histories', PaymentHistoryController::class);
Route::apiResource('/category', CategoryController::class);
Route::apiResource('/dta-sug', DtaSugController::class);
Route::apiResource('/ota-sug', OtaSugController::class);
Route::post('/files/upload/{dir}', [UploadFileController::class, 'store']);

//Notification Route
Route::prefix('notification')->group(function () {
    Route::apiResource('', NotificationController::class);
    Route::put('updateStatus', [NotificationController::class, 'updateStatus']);
    Route::post('sale-notification/{id}', [NotificationController::class, 'saleNotification']);
    Route::get('unseen', [NotificationController::class, 'unseen']);
    Route::get('seen', [NotificationController::class, 'seen']);
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
//Follow
Route::group([
    'prefix' => 'follow'
], function ($router) {
    Route::post('/{id}', [\App\Http\Controllers\Api\FollowUserController::class, 'follow']);
    Route::get('/{id}', [\App\Http\Controllers\Api\FollowUserController::class, 'isFollow']);
    Route::delete('/{id}', [\App\Http\Controllers\Api\FollowUserController::class, 'unFollow']);
});

//report
Route::group([
    'prefix' => 'report'
], function ($router) {
    Route::apiResource('user', \App\Http\Controllers\Admin\ReportUserController::class);
    Route::apiResource('post', \App\Http\Controllers\Admin\ReportPostController::class);
});

//ban
Route::get('/ban/user', [\App\Http\Controllers\Admin\BanController::class, 'userBan']);
Route::post('/ban', [\App\Http\Controllers\Admin\BanController::class, 'ban']);
Route::post('/unban', [\App\Http\Controllers\Admin\BanController::class, 'unban']);

