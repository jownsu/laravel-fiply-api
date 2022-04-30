<?php

namespace App\Http\Controllers\api;

use App\Actions\Fiply\Auth\CreateUser;
use App\Actions\Fiply\Auth\HiringManagerOTP;
use App\Actions\Fiply\Auth\LoginUser;
use App\Actions\Fiply\Auth\Verify;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\VerificationRequest;
use App\Models\Company;
use App\Models\HiringManager;
use App\Models\HiringManagerToken;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request, CreateUser $action){

        $input = $request->validated();

        $user = $action->handle($input);

        if(!$user) return response()->error('Verification Code not match');

        return response()->success($user, 201);
    }

    public function login(LoginRequest $request, LoginUser $action){
        $input = $request->validated();
        $user = $action->handle($input);

        if (!$user) return response()->error('Incorrect Email/Password');

//        $userData = new UserResource($user);

        return response()->success($user, 201);
    }

    public function sendVerification(VerificationRequest $request, Verify $action)
    {
        $input = $request->validated();

        if(!$this->isOnline()){
            return response()->error("Check your internet connection.");
        }
        $verify = $action->handle($input);

        if(!$verify) return response()->error('Email is already registered');

        return response()->success('Verification sent to your email');
    }

    private function isOnline($site = 'https://google.com/')
    {
        if(@fopen($site, "r")){
            return true;
        }else{
            return false;
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->success(['message' => 'Logged Out']);
    }

    public function checkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email']
        ]);

        $email = User::where('email', $validated['email'])->count();

        return response()->success($email == 1 ? true : false);
    }

/*    public function otpHiringManager(Request $request, HiringManagerOTP $action)
    {
        $input = $request->validate([
            'hiring_manager_id' => ['required']
        ]);

        $hiringManager = HiringManager::where('id', $input['hiring_manager_id'])->first();

        if(auth()->user()->cannot('create', $hiringManager)){
            return response()->error('User do not own this Hiring Manager');
        };

        if(!$this->isOnline()){
            return response()->error("Check your internet connection.");
        }

        $verify = $action->handle($hiringManager->email);

        if(!$verify) return response()->error('Hiring Manager dont exists');

        return response()->success('Verification sent to your email');
    }*/

    public function loginAsHiringManager(Request $request)
    {
        $input = $request->validate([
            'hiring_manager_id' => ['required'],
            'code'              => ['required']
        ]);

        $hiringManager = HiringManager::where('id', $request->hiring_manager_id)->first();

        if(!$hiringManager || !Hash::check($input['code'], $hiringManager->code)){
            return response()->error('Code Not Match/Invalid');
        }

        $randomCode = random_int(100000, 999999);

        $hiringToken = Crypt::encryptString($randomCode);

        HiringManagerToken::updateOrInsert(
            [
                'tokenable_type' => get_class($hiringManager),
                'tokenable_id' => $hiringManager->id,
            ],
            [
                'token' => bcrypt($randomCode)
            ],
        );

        $data = [
            'id'        => $hiringManager->id,
            'name'      => $hiringManager->firstname . ' ' . $hiringManager->lastname,
            'firstname' => $hiringManager->firstname,
            'lastname'  => $hiringManager->lastname,
            'avatar'    => $hiringManager->avatar(),
            'token'     => $hiringToken
        ];

        return response()->success($data);
    }

    public function loginAsEmployerAdmin(Request $request)
    {
        $input = $request->validate([
            'code' => ['required']
        ]);

        $company = auth()->user()->company;


        if(!Hash::check($input['code'], $company->code)){
            return response()->error('Code Not Match/Invalid');
        }

        $randomCode = random_int(100000, 999999);

        $hiringToken = Crypt::encryptString($randomCode);


        HiringManagerToken::updateOrInsert(
            [
                'tokenable_type' => get_class($company),
                'tokenable_id' => $company->id,
            ],
            [
                'token' => bcrypt($randomCode)
            ]
        );

        $data = [
            'token'     => $hiringToken
        ];

        return response()->success($data);
    }

    public function logoutAsEmployer(Request $request)
    {

        $input = $request->validate([
            'type' => ['required', Rule::in(['company', 'hiring_manager'])]
        ]);

        $token = HiringManagerToken::where('tokenable_id', $request->header('hiring_id'))
            ->when($input['type']  == 'hiring_manager', function($q){
                return $q->where('tokenable_type', HiringManager::class);
            })
            ->when($input['type'] == 'company', function($q){
                return $q->where('tokenable_type', Company::class);
            })
            ->first();

        return $token->delete();
    }

    public function test()
    {
        return 'hello dipshit';
    }

}
