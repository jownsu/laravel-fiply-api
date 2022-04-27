<?php

namespace App\Actions\Fiply\Auth;
use App\Models\HiringManager;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HiringManagerOTP{

    public function handle(string $email)
    {
        $hiringManager = HiringManager::where('email', $email)->first();

        if(!$hiringManager) return false;

        $code = random_int(100000, 999999);

        $mail_data = [
            'recipient' => $email,
            'fromEmail' => 'carja@fiply.tech',
            'fromName' => 'Fiply',
            'subject' => 'Verify Your Email',
            //'body'  => 'Your Verification code is ' . $code
        ];


        Mail::send('email', ['code' => $code, 'body' => 'Your Verification Code to login as Hiring Manager is '], function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'], $mail_data['fromName'])
                ->subject($mail_data['subject']);
        });

        $hiringManager->code = bcrypt($code);

        $hiringManager->save();

        return true;
    }
}
