<?php

namespace App\Http\Controllers\api;

use App\Actions\Fiply\Auth\CreateUser;
use App\Actions\Fiply\Auth\LoginUser;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request, CreateUser $action){
        $input = $request->validated();

        $user = $action->handle($input);

        if(!$user) return response()->error('Register Error');

        return response()->success($user, 201);
    }

    public function login(LoginRequest $request, LoginUser $action){
        $input = $request->validated();
        $user = $action->handle($input);

        if (!$user) return response()->error('Incorrect Email/Password');

//        $userData = new UserResource($user);

        return response()->success($user, 201);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->success(['message' => 'Logged Out']);
    }
}
