<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\{AppliedJobController,
    CommentController,
    CommunityController,
    datasets\JobCategoryController,
    DocumentController,
    JobController,
    PostController,
    SavedJobController,
    UpVoteController,
    datasets\DegreeController,
    datasets\UniversityController,
    datasets\ValidIdController,
    datasets\EmploymentTypeController,
    datasets\JobTitleController,
    datasets\LocationController,
    datasets\PositionLevelController,
    user\EducationalBackgroundController,
    user\ExperienceController,
    user\FollowController,
    user\JobPreferenceController,
    user\UserController,
    user\PostController as UserPostController,
    user\AppliedJobController as UserAppliedJobController,
    user\SavedJobController as UserSavedJobController,
    user\SavedPostController as UserSavedPostController,
    user\ProfileController};
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
Route::apiResource('/jobCategories', JobCategoryController::class)->only(['index']);
Route::apiResource('/employmentTypes', EmploymentTypeController::class)->only(['index']);
Route::apiResource('/positionLevels', PositionLevelController::class)->only(['index']);
Route::apiResource('/validIds', ValidIdController::class)->only(['index']);

Route::post('/checkEmail', [AuthController::class, 'checkEmail']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/token/logout', [AuthController::class, 'logout']);

    Route::apiResource('/posts', PostController::class);
    Route::apiResource('/posts/{post}/comments', CommentController::class)->only(['index', 'store']);
    Route::get('/posts/{post}/upVotes', [UpVoteController::class, 'index']);
    Route::post('/posts/upVote', [UpVoteController::class, 'upVote']);
    Route::post('/posts/save', [UserSavedPostController::class, 'savePost']);
    Route::apiResource('/comments', CommentController::class)->only(['update', 'destroy']);

    Route::apiResource('/jobs', JobController::class);
    Route::get('/jobs/{job}/saves', [SavedJobController::class, 'index']);
    Route::get('/jobs/{job}/applies', [AppliedJobController::class, 'index']);
    Route::post('/jobs/save', [SavedJobController::class, 'saveJob']);
    Route::post('/jobs/unSave', [SavedJobController::class, 'unSaveJob']);
    Route::post('/jobs/apply', [AppliedJobController::class, 'applyJob']);
    Route::post('/jobs/unApply', [AppliedJobController::class, 'unApplyJob']);

    Route::apiResource('/experiences', ExperienceController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/educationalBackgrounds', EducationalBackgroundController::class)->only(['store', 'update', 'destroy']);

    Route::put('/uploadAvatar', [UserController::class, 'uploadAvatar']);
    Route::put('/uploadCover', [UserController::class, 'uploadCover']);
    Route::put('/uploadResume', [UserController::class, 'uploadResume']);
    Route::put('/uploadValidId', [UserController::class, 'uploadValidId']);

    Route::post('/follow', [FollowController::class, 'follow']);
    Route::post('/unFollow', [FollowController::class, 'unFollow']);
    Route::post('/acceptFollowRequest', [FollowController::class, 'acceptFollowRequest']);

    //Community
    Route::apiResource('/users', CommunityController::class)->only(['index']);

    Route::group(['prefix' => '/{user}'], function() {

        Route::apiResource('/', UserController::class)->only('index');
        Route::apiResource('/experiences', ExperienceController::class)->only('index');
        Route::apiResource('/educationalBackgrounds', EducationalBackgroundController::class)->only('index');
        Route::apiResource('/jobPreferences', JobPreferenceController::class)->only(['index', 'store']);
        Route::apiResource('/posts', UserPostController::class)->except('show');
        Route::apiResource('/appliedJobs', UserAppliedJobController::class)->only('index');
        Route::apiResource('/savedJobs', UserSavedJobController::class)->only('index');
        Route::apiResource('/savedPosts', UserSavedPostController::class)->only('index');

        Route::get('/following', [FollowController::class, 'following']);
        Route::get('/followers', [FollowController::class, 'followers']);
        Route::get('/followerRequests', [FollowController::class, 'followerRequests']);
        Route::get('/followPendings', [FollowController::class, 'followPendings']);

    });


});










//if route does not exists
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact fiply@gmail.com'], 404);
});

