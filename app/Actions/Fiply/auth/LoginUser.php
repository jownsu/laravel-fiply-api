<?php

namespace App\Actions\Fiply\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUser{

    public function handle(array $input)
    {
        $user = User::where('email', $input['email'])->first();

        if(!$user || !Hash::check($input['password'] ,$user->password)){
            return false;
        }

        $token = $user->createToken('FiplyToken')->plainTextToken;

        $account_level = '';
        $preview = 'Not Verified';

        if($user->jobPreference()->exists()){
            $account_level = 'Basic User';
            $preview = $user->jobPreference->job_title;
        }

        $data = [
            'id'            =>  $user->id,
            'fullname'      =>  $user->profile->fullname(),
            'status'        =>  $user->profile->status,
            'description'   =>  $user->profile->description,
            'avatar'        =>  $user->profile->avatar(),
            'preview'       =>  $preview,
            'account_level' =>  $account_level,
            'token'         =>  $token,
        ];
        return $data;
    }
}
