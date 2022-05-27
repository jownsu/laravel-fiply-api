<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\Company;
use App\Models\HiringManagerToken;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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

            if($user->company()->exists()){
                $moreInfo = [
                    'name'    => $user->company->name,
                    'avatar'  =>  $user->company->avatar(),
                    'company' => $user->company->id
                ];
            }else{
                $moreInfo = [
                    'name'       =>  $user->profile->fullname(),
                    'firstname'  =>  $user->profile->firstname,
                    'lastname'   =>  $user->profile->lastname,
                    'avatar'     =>  $user->profile->avatar(),
                ];
            }

            $data = array_merge([
                'id'                =>  $user->id,
                'account_level'     =>  $account_level['account_level'],
                'account_level_str' =>  $account_level['account_level_str'],
            ], $moreInfo);

            if($user->is_admin){
                $data = array_merge($data, ['is_admin' => $user->is_admin]);
            }

            return response()->json($data, 200);
        }

        return response()->error(['error' => 'Invalid credentials']);


    }

    public function loginAsAdmin(Request $request)
    {
        $request->validate(
            [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]
        );

        if (Auth::guard()->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => true
        ])) {
            $user = Auth::user();

            $request->session()->regenerate();

            return response()->json([
                'id'        => $user->id,
                'email'     => $user->email,
                'is_admin'  => $user->is_admin
            ], 200);
        }

        return response()->error(['error' => 'Invalid credentials']);
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

        if(array_key_exists("profile", $input) && !empty($input['profile'])){
            $user->profile()->create([
                'firstname' => $input['profile']['firstname'],
                'lastname'  => $input['profile']['lastname'],
                'birthday'  => $input['profile']['birthday']
            ]);
        }

        if(array_key_exists("job_preference", $input) && !empty($input['job_preference'])){
            $user->jobPreference()->create([
                'job_title'         => $input['job_preference']['job_title'],
                'location'          => $input['job_preference']['location'],
                'employment_type'   => $input['job_preference']['employment_type'],
            ]);
        }

        if(array_key_exists("company", $input) && !empty($input['company'])){
            $user->company()->create([
                'name'                => $input['company']['name'],
                'registration_no'     => $input['company']['registration_no'],
                'telephone_no'        => $input['company']['telephone_no'],
                'location'            => $input['company']['location'],
                'code'                => bcrypt($input['company']['code'])
            ]);
        }

        if(array_key_exists("applicant_preference", $input) && !empty($input['applicant_preference'])){
            $user->company->applicantPreference()->create([
                'level_of_experience' => $input['applicant_preference']['level_of_experience'],
                'field_of_expertise'  => $input['applicant_preference']['field_of_expertise'],
                'location'            => $input['applicant_preference']['location']
            ]);
        }

        $userVerify->delete();

        if (Auth::guard()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $account_level = $user->account_level();

            if($user->company){

                $randomCode = random_int(100000, 999999);

                $hiringToken = Crypt::encryptString($randomCode);

                HiringManagerToken::updateOrInsert(
                    [
                        'tokenable_type' => Company::class,
                        'tokenable_id' => $user->company->id,
                    ],
                    [
                        'token' => bcrypt($randomCode)
                    ]
                );

                $moreInfo = [
                    'name'         => $user->company->name,
                    'avatar'       =>  $user->company->avatar(),
                    'company'      => $user->company->id,
                    'companyToken' => $hiringToken
                ];
            }else{
                $moreInfo = [
                    'name'       =>  $user->profile->fullname(),
                    'firstname'  =>  $user->profile->firstname,
                    'lastname'   =>  $user->profile->lastname,
                    'avatar'     =>  $user->profile->avatar(),
                ];
            }

            $data = array_merge([
                'id'                =>  $user->id,
                'account_level'     =>  $account_level['account_level'],
                'account_level_str' =>  $account_level['account_level_str'],
            ], $moreInfo);

            return response()->json($data, 200);
        }

        return response()->error(['error' => 'Invalid credentials']);

    }
}
