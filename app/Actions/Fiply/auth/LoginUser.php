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
