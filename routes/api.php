<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('profile', [AuthController::class, 'profile']);

    // Các route yêu cầu phải login (sử dụng middleware bạn đã alias là jwt.auth)
    Route::group(['middleware' => 'jwt.auth'], function () { // Các route ở đây sẽ yêu cầu phải có token hợp lệ mới truy cập được
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
Route::prefix('user')->group(function () {
    Route::resources(['categories' => CategoryController::class]);
    Route::resources(['products' => ProductController::class]);
});

