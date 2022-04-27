<?php

namespace App\Actions\Fiply\Auth;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CreateUser{

    public function handle(array $input)
    {
        $userVerify = UserVerify::where('email', $input['email'])->first();

        if(!$userVerify || !Hash::check($input['code'] ,$userVerify->code)){
            return false;
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

        $token = $user->createToken('FiplyToken')->plainTextToken;

        $account_level = $user->account_level();

        if($user->company){
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
            'token'             =>  $token,
        ], $moreInfo);

        return $data;
    }
}
