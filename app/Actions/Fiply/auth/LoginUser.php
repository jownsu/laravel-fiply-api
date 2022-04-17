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

        $account_level = $user->account_level();

        $data = [
            'id'                =>  $user->id,
            'fullname'          =>  $user->profile->fullname(),
            'firstname'         =>  $user->profile->firstname,
            'lastname'          =>  $user->profile->lastname,
            'avatar'            =>  $user->profile->avatar(),
            'account_level'     =>  $account_level['account_level'],
            'account_level_str' =>  $account_level['account_level_str'],
            'token'             =>  $token,
        ];
        return $data;
    }
}
