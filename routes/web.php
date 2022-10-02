<?php

// Authentication...
use App\Http\Controllers\web\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/loginAsAdmin', [AuthController::class, 'loginAsAdmin']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/signup', [AuthController::class, 'register']);
