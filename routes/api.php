<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\api\{CommentController,
    EmploymentTypeController,
    JobController,
    JobTitleController,
    LocationController,
    PostController,
    UniversityController,
    UpVoteController,
    user\EducationalBackgroundController,
    user\ExperienceController,
    user\PostController as UserPostController,
    user\ProfileController,
    user\UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//PUBLIC ROUTES
Route::post('/token/login', [ AuthController::class,'login' ]);
Route::post('/token/register', [ AuthController::class, 'register' ]);

Route::apiResource('/locations', LocationController::class)->only(['index']);
Route::apiResource('/universities', UniversityController::class)->only(['index']);
Route::apiResource('/degrees', DegreeController::class)->only(['index']);
Route::apiResource('/jobTitles', JobTitleController::class)->only(['index']);
Route::apiResource('/employmentTypes', EmploymentTypeController::class)->only(['index']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/token/logout', [AuthController::class, 'logout']);

    Route::apiResource('/posts', PostController::class);
    Route::apiResource('/posts/{post}/comments', CommentController::class)->only(['index', 'store']);
    Route::apiResource('/posts/{post}/upVotes', UpVoteController::class)->only(['index', 'store']);
    Route::apiResource('/comments', CommentController::class)->only(['update', 'destroy']);
    Route::apiResource('/jobs', JobController::class)->only(['index', 'show']);

    Route::group(['prefix' => '/{user}'], function() {
        Route::apiResource('/', UserController::class)->only('index');
        Route::apiResource('/experiences', ExperienceController::class)->only('index');
        Route::apiResource('/educationalBackgrounds', EducationalBackgroundController::class)->only('index');
        Route::apiResource('/posts', UserPostController::class)->except('show');
    });


});










//if route does not exists
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact fiply@gmail.com'], 404);
});

