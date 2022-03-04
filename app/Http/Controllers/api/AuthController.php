<?php

namespace App\Http\Controllers\api;

use App\Actions\Fiply\Auth\CreateUser;
use App\Actions\Fiply\Auth\LoginUser;
use App\Actions\Fiply\Auth\Verify;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\VerificationRequest;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $verify = $action->handle($input);

        if(!$verify) return response()->error('Email is already registered');

        return response()->success('Verification sent to your email');
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->success(['message' => 'Logged Out']);
    }
}
