<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]
        );

        if (Auth::guard()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $account_level = $user->account_level();

            $data = [
                'id'                =>  $user->id,
                'fullname'          =>  $user->profile->fullname(),
                'avatar'            =>  $user->profile->avatar(),
                'cover'             =>  $user->profile->cover(),
                'account_level'     =>  $account_level['account_level'],
                'account_level_str' =>  $account_level['account_level_str'],
                'email'             =>  $user->email

            ];
            return response()->json($data, 200);
        }

        return response()->json(['error' => 'Invalid credentials']);



/*        $user = User::where('email', $input['email'])->first();

        if(!$user || !Hash::check($input['password'] ,$user->password)){
            return response()->json(['error' => 'Invalid credentials'], 400);
        }

        $request->session()->regenerate();

        $account_level = $user->account_level();

        $data = [
            'id'                =>  $user->id,
            'fullname'          =>  $user->profile->fullname(),
            'avatar'            =>  $user->profile->avatar(),
            'cover'             =>  $user->profile->cover(),
            'account_level'     =>  $account_level['account_level'],
            'account_level_str' =>  $account_level['account_level_str'],
            'email'             =>  $user->email

        ];

        return response()->json($data, 200);*/

/*        if (Auth::guard()->attempt($request->only('email', 'password'))) {

        }*/

    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([], 204);
    }

    public function register(RegisterRequest $request){

        $input = $request->validated();

        $userVerify = UserVerify::where('email', $input['email'])->first();

        if(!$userVerify || !Hash::check($input['code'] ,$userVerify->code)){
            return response()->error('Verification Code not match');
        }

        $user = User::create([
            'email'             => $input['email'],
            'password'          => bcrypt($input['password']),
            'email_verified_at' => Carbon::now()

        ]);

        $user->profile()->create([
            'firstname' => $input['firstname'],
            'lastname'  => $input['lastname'],
            'birthday'  => $input['birthday']
        ]);

        if(array_key_exists("job_preference", $input)){
            $user->jobPreference()->create([
                'job_title'         => $input['job_preference']['job_title'],
                'location'          => $input['job_preference']['location'],
                'employment_type'   => $input['job_preference']['employment_type'],
                'status'            => 'Looking for a job'
            ]);
        }

        $userVerify->delete();

        if (Auth::guard()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $account_level = $user->account_level();

            $data = [
                'id'                =>  $user->id,
                'fullname'          =>  $user->profile->fullname(),
                'avatar'            =>  $user->profile->avatar(),
                'cover'             =>  $user->profile->cover(),
                'account_level'     =>  $account_level['account_level'],
                'account_level_str' =>  $account_level['account_level_str'],
                'email'             =>  $user->email

            ];
            return response()->json($data, 200);
        }

        return response()->json(['error' => 'Invalid credentials']);

    }
}
