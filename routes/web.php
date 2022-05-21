<?php

// Authentication...
use App\Http\Controllers\web\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/loginAsAdmin', [AuthController::class, 'loginAsAdmin']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/signup', [AuthController::class, 'register']);
/*$limiter = config('fortify.limiters.login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:'.config('fortify.guard'),
        $limiter ? 'throttle:'.$limiter : null,
    ]));

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth:sanctum');*/
