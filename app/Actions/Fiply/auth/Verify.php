<?php

namespace App\Actions\Fiply\Auth;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Verify{

    public function handle(array $input)
    {
        $user = User::where('email', $input['email'])->first();

        if($user) return false;

        $code = random_int(100000, 999999);
        $img = asset('img/maill.png');

        $mail_data = [
            'recipient' => $input['email'],
            'fromEmail' => 'carja@fiply.tech',
            'fromName' => 'Fiply',
            'subject' => 'Please Verify Your Email',
            //'body'  => 'Your Verification code is ' . $code
        ];

        Mail::send('email', ['code' => $code, 'img' => $img], function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'], $mail_data['fromName'])
                ->subject($mail_data['subject']);
        });

        UserVerify::updateOrInsert(
            [
                'email' => $input['email'],
            ],
            [
                'code' => bcrypt($code)
            ]
        );

        return true;
    }
}
