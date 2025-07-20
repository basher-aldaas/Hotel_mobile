<?php

namespace App\Action;

use App\Mail\SendResetCodePasswordMail;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ResetPasswordAction
{

    public function user_forgot_password($request) : array
    {
        ResetCodePassword::query()->where('email' , $request['email'])->delete();

        $data['code'] = mt_rand(100000 , 999999);

        $codeData = ResetCodePassword::query()->updateOrCreate([
            'email' => $request['email'],
            'code' => $data['code'],
            'created_at' => now(),
        ]);

        Mail::to($request['email'])->send(new SendResetCodePasswordMail($codeData['code']));
        return [
            'data' => $codeData,
            'message' => 'Send the new code to the input email',
            'code' => 200,
        ];
    }

    public function user_check_code($request) : array
    {
        $passwordReset = ResetCodePassword::query()->where('code' , $request['code'])->first();
        if ($passwordReset['created_at']->addHour() < now()) {
            $passwordReset->delete();
            $data = [];
            $message = 'This code is expired';
            $code = 422;
        }

        $data = $passwordReset['code'];
        $message = 'This code is correct';
        $code = 200;

        return [
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ];
    }

    public function user_reset_password($request) : array
    {
        $passwordReset = ResetCodePassword::query()->where('code' , $request['code'])->first();
        if ($passwordReset['created_at']->addHour() < now()){
            $passwordReset->delete();
            $data = [];
            $message = 'This code is expired';
            $code = 422;
        }

        $user = User::query()->where('email' , $passwordReset['email'])->first();
        if (!$user) {
            return [
                'data' => [],
                'message' => 'User not found',
                'code' => 404,
            ];
        }
        $user->update([
            'password' => bcrypt($request['password']),
        ]);
        $passwordReset->delete();

        return [
            'data' => $user ,
            'message' => 'Password has been successfully reset',
            'code' => 200
        ];
    }

}
