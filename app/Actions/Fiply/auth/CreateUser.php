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

        $user->profile()->create([
            'firstname' => $input['firstname'],
            'lastname'  => $input['lastname']
        ]);

        if(array_key_exists("job_preference", $input)){
            $user->jobPreference()->create([
                'job_title'         => $input['job_preference']['job_title'],
                'location'          => $input['job_preference']['location'],
                'employment_type'   => $input['job_preference']['employment_type']
            ]);
        }

        $userVerify->delete();

        $token = $user->createToken('FiplyToken')->plainTextToken;

        $data = [
            'id'            =>  $user->id,
            'fullname'      =>  $user->profile->fullname(),
            'status'        =>  $user->profile->status ?? 'Not Verified',
            'description'   =>  $user->profile->description,
            'avatar'        =>  $user->profile->avatar,
            'token'         =>  $token,
        ];

        return $data;
    }
}
