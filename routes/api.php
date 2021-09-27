<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdoptController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::put('/user/topup/{id}/{amount}' , [UserController::class , 'topup']);

Route::get('/user/notification/{id}' , [UserController::class , 'notification']);

Route::apiResource('/notification', NotificationController::class);

Route::apiResource('/adopt', AdoptController::class);

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
});
