<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\checkRole;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/register', [AuthController::class, 'register'])->middleware(checkRole::class . ':admin');
});
