<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\api\{
    AppliedJobController,
    CommentController,
    EmploymentTypeController,
    JobController,
    JobTitleController,
    LocationController,
    PostController,
    SavedJobController,
    UniversityController,
    UpVoteController,
    user\EducationalBackgroundController,
    user\ExperienceController,
    user\PostController as UserPostController,
    user\AppliedJobController as UserAppliedJobController,
    user\SavedJobController as UserSavedJobController,
    user\ProfileController,
    user\UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//PUBLIC ROUTES
Route::post('/token/login', [ AuthController::class,'login']);
Route::post('/token/register', [ AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'sendVerification']);

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

    Route::apiResource('/jobs', JobController::class);
    Route::apiResource('/jobs/{job}/saves', SavedJobController::class)->only('store');
    Route::apiResource('/jobs/{job}/applies', AppliedJobController::class)->only('store');

    Route::group(['prefix' => '/{user}'], function() {
        Route::apiResource('/', UserController::class)->only('index');
        Route::apiResource('/experiences', ExperienceController::class)->only('index');
        Route::apiResource('/educationalBackgrounds', EducationalBackgroundController::class)->only('index');
        Route::apiResource('/posts', UserPostController::class)->except('show');
        Route::apiResource('/appliedJobs', UserAppliedJobController::class)->only('index');
        Route::apiResource('/savedJobs', UserSavedJobController::class)->only('index');
    });


});










//if route does not exists
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact fiply@gmail.com'], 404);
});

