<?php

namespace App\Actions\Fiply\Auth;
use App\Models\User;

class CreateUser{

    public function handle(array $input)
    {
        $user = User::create([
            'email'    => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        $user->profile()->create([
            'firstname' => $input['firstname'],
            'lastname'  => $input['lastname']
        ]);

        $token = $user->createToken('FiplyToken')->plainTextToken;

        $data = [
            'id'            =>  $user->id,
            'fullname'      =>  $user->profile->fullname(),
            'status'        =>  $user->profile->status ?? 'Not Verified',
            'description'   =>  $user->profile->description,
            'avatar'        =>  $user->profile->avatar,
            'token'         =>  $token,
        ];

/*        $user->jobPreferences()->create([
            'job_title'       => $input['job_title'],
            'location'        => $input['location'],
            'employment_type' => $input['employment_type']
        ]);*/

        return $data;
    }
}
