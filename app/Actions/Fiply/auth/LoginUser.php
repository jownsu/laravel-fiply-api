<?php

namespace App\Actions\Fiply\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUser{

    public function handle(array $input)
    {
        $user = User::where('email', $input['email'])->with('company')->first();

        if(!$user || !Hash::check($input['password'] ,$user->password)){
            return false;
        }

        $token = $user->createToken('FiplyToken')->plainTextToken;

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
            'token'             =>  $token,
        ], $moreInfo);

        if($user->is_admin){
            $data = array_merge($data, ['is_admin' => $user->is_admin]);
        }

        return $data;
    }
}
