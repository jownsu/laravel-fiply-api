<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\web\AdminController;
use App\Http\Controllers\api\{AppliedJobController,
    CommentController,
    CommunityController,
    company\ApplicantPreferenceController,
    company\CompanyController,
    company\DashboardController,
    company\HiringManagerController,
    company\hiringManager\HiringManagerController as UserHiringManagerController,
    datasets\CompanyCertificateController,
    datasets\DegreeCategoryController,
    datasets\JobCategoryController,
    JobController,
    company\JobController as EmployerJobController,
    NotificationController,
    PostController,
    QuestionController,
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
Route::post('/token/loginAsAdmin', [ AuthController::class,'loginAsAdmin']);
Route::post('/token/register', [ AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'sendVerification']);

Route::apiResource('/locations', LocationController::class)->only(['index']);
Route::apiResource('/universities', UniversityController::class)->only(['index']);
Route::apiResource('/degrees', DegreeController::class)->only(['index', 'show']);
Route::apiResource('/degreeCategories', DegreeCategoryController::class)->only(['index']);
Route::apiResource('/jobTitles', JobTitleController::class)->only(['index', 'show']);
Route::apiResource('/jobCategories', JobCategoryController::class)->only(['index']);
Route::apiResource('/employmentTypes', EmploymentTypeController::class)->only(['index']);
Route::apiResource('/positionLevels', PositionLevelController::class)->only(['index']);
Route::apiResource('/validIds', ValidIdController::class)->only(['index']);
Route::apiResource('/companyCertificates', CompanyCertificateController::class)->only(['index']);

Route::post('/checkEmail', [AuthController::class, 'checkEmail']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/token/logout', [AuthController::class, 'logout']);
    Route::post('/loginAsHiringManager', [AuthController::class, 'loginAsHiringManager']);
    Route::post('/loginAsEmployerAdmin', [AuthController::class, 'loginAsEmployerAdmin']);

    Route::group(['middleware' => ['admin']], function (){
        Route::apiResource('/universities', UniversityController::class)->except('index');
        Route::apiResource('/employmentTypes', EmploymentTypeController::class)->except('index');
        Route::apiResource('/positionLevels', PositionLevelController::class)->except('index');
        Route::apiResource('/validIds', ValidIdController::class)->except('index');
        Route::apiResource('/companyCertificates', CompanyCertificateController::class)->except('index');

        Route::apiResource('/jobTitles', JobTitleController::class)->except('index');
        Route::apiResource('/jobCategories', JobCategoryController::class)->except('index');

        Route::apiResource('/degrees', DegreeController::class)->except(['index', 'show']);
        Route::apiResource('/degreeCategories', DegreeCategoryController::class)->except('index');

        Route::get('/jobSeekers', [AdminController::class, 'getJobSeekers']);
        Route::get('/jobSeekers/{id}', [AdminController::class, 'getJobSeeker']);
        Route::get('/companies', [AdminController::class, 'getCompanies']);
        Route::get('/companies/{id}', [AdminController::class, 'getCompany']);
        Route::get('/companiesRequests', [AdminController::class, 'getCompaniesRequests']);
        Route::get('/jobSeekerRequests', [AdminController::class, 'getJobSeekerRequests']);
        Route::post('/verifyJobSeeker', [AdminController::class, 'verifyJobSeeker']);
        Route::post('/rejectJobSeeker', [AdminController::class, 'rejectJobSeeker']);
        Route::post('/verifyCompany', [AdminController::class, 'verifyCompany']);
        Route::post('/rejectCompany', [AdminController::class, 'rejectCompany']);
        Route::get('/adminDashboard', [AdminController::class, 'adminDashboard']);
    });

    Route::apiResource('/posts', PostController::class)->except('show');
    Route::put('/posts/{post}/setAudience', [PostController::class, 'setAudience']);
    Route::apiResource('/posts/{post}/comments', CommentController::class)->only(['index', 'store']);
    Route::get('/posts/{post}/upVotes', [UpVoteController::class, 'index']);
    Route::post('/posts/upVote', [UpVoteController::class, 'upVote']);
    Route::post('/posts/save', [UserSavedPostController::class, 'savePost']);
    Route::post('/posts/unSave', [UserSavedPostController::class, 'unSavePost']);
    Route::apiResource('/comments', CommentController::class)->only(['update', 'destroy']);

    Route::apiResource('/jobs', JobController::class)->only(['show', 'index']);
    Route::apiResource('/jobs/{job}/questions', QuestionController::class)->only('index');
    Route::get('/jobs/{job}/saves', [SavedJobController::class, 'index']);
    Route::get('/jobs/{job}/applies', [AppliedJobController::class, 'index']);
    Route::post('/jobs/save', [SavedJobController::class, 'saveJob']);
    Route::post('/jobs/unSave', [SavedJobController::class, 'unSaveJob']);
    Route::post('/jobs/apply', [AppliedJobController::class, 'applyJob']);
    Route::post('/jobs/unApply', [AppliedJobController::class, 'unApplyJob']);

    //uploads
    Route::put('/uploadAvatar', [UserController::class, 'uploadAvatar']);
    Route::put('/uploadCover', [UserController::class, 'uploadCover']);
    Route::put('/uploadResume', [UserController::class, 'uploadResume']);
    Route::put('/uploadValidId', [UserController::class, 'uploadValidId']);

    // Try kung gagana pag ililipat sa company middleware
    Route::put('/uploadCompanyId', [CompanyController::class, 'uploadCompanyId']);
    Route::put('/uploadCertificate', [CompanyController::class, 'uploadCertificate']);

    Route::post('/follow', [FollowController::class, 'follow']);
    Route::post('/unFollow', [FollowController::class, 'unFollow']);
    Route::post('/removeFollower', [FollowController::class, 'removeFollower']);
    Route::post('/acceptFollowRequest', [FollowController::class, 'acceptFollowRequest']);

    //Community
    Route::apiResource('/users', CommunityController::class)->only(['index']);

    Route::group(['middleware' => ['company']], function (){
        //Route::get('/test', [AuthController::class, 'test']);
        Route::apiResource('/dashboard', DashboardController::class)->only('index');
        Route::post('/logoutAsEmployer', [AuthController::class, 'logoutAsEmployer']);

        Route::group(['middleware' => ['canHire:company'], 'prefix' => '/ea'], function (){
            Route::apiResource('/hiringManagers', HiringManagerController::class)->except('index', 'show');
        });

        Route::group(['middleware' => ['canHire:hiring_manager'], 'prefix' => '/hm'], function (){
            Route::get('/profile', [UserHiringManagerController::class, 'index']);
            Route::get('/jobs/interviews', [EmployerJobController::class, 'getInterviews']);
            Route::get('/jobs/{job}/applicants', [EmployerJobController::class, 'getApplicants']);
            Route::get('/jobs/{job}/applicantsInterview', [EmployerJobController::class, 'getApplicantsInteview']);
            Route::apiResource('/jobs', EmployerJobController::class);

            Route::get('/jobs/{jobId}/response/{applyId}', [EmployerJobController::class, 'jobResponse']);
            Route::post('/jobs/{jobId}/response/{applyId}', [EmployerJobController::class, 'jobRemark']);
            Route::post('/jobs/{jobId}/response/{applyId}/reject', [EmployerJobController::class, 'rejectJob']);
            Route::post('/jobs/{jobId}/response/{applyId}/hire', [EmployerJobController::class, 'hire']);
            //Route::get('/test', [AuthController::class, 'test']);
        } );
        Route::group(['prefix' => '/me'], function() {
            Route::apiResource('/hiringManagers', HiringManagerController::class)->only(['index', 'show']);
        });
    });





    Route::group(['prefix' => '/me'], function() {
        Route::put('/', [UserController::class, 'update']);
        Route::put('/setAudience', [UserController::class, 'setAudience']);
        Route::apiResource('/savedPosts', UserSavedPostController::class)->only('index');
        Route::apiResource('/appliedJobs', UserAppliedJobController::class)->only('index');
        Route::get('/appliedPendingJobs', [UserAppliedJobController::class, 'pendingJob']);
        Route::get('/rejectedJobs', [UserAppliedJobController::class, 'rejectedJob']);
        Route::get('/passedJobs', [UserAppliedJobController::class, 'passedJobs']);
        Route::get('/appliedPendingJobs/{id}', [UserAppliedJobController::class, 'showPendingJob']);
        Route::apiResource('/savedJobs', UserSavedJobController::class)->only('index');
        Route::get('/followerRequests', [FollowController::class, 'followerRequests']);
        Route::get('/followPendings', [FollowController::class, 'followPendings']);

        Route::apiResource('/notifications', NotificationController::class)->only(['index', 'destroy']);

        Route::apiResource('/experiences', ExperienceController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/educationalBackgrounds', EducationalBackgroundController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/jobPreferences', JobPreferenceController::class)->only(['store', 'update']);
        Route::apiResource('/applicantPreferences', ApplicantPreferenceController::class)->only(['store', 'update']);
    });

    Route::group(['prefix' => '/{user}'], function() {
        Route::get('/', [UserController::class, 'index']);
        Route::apiResource('/posts', UserPostController::class)->except('show');
        Route::apiResource('/experiences', ExperienceController::class)->only('index');
        Route::apiResource('/educationalBackgrounds', EducationalBackgroundController::class)->only('index');
        Route::apiResource('/jobPreferences', JobPreferenceController::class)->only(['index']);
        Route::apiResource('/applicantPreferences', ApplicantPreferenceController::class)->only(['index']);

        Route::get('/resume', [UserController::class, 'getResume']);

        Route::get('/following', [FollowController::class, 'following']);
        Route::get('/followers', [FollowController::class, 'followers']);

    });
});

//if route does not exists
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact carja@fiply.tech'], 404);
});
