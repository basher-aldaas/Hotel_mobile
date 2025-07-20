<?php

namespace App\Http\Controllers\Auth;

use App\Action\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPassword\UserCheckCodeRequest;
use App\Http\Requests\Auth\ResetPassword\UserForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPassword\UserResetPasswordRequest;
use App\Http\Responses\Response;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    private ResetPasswordAction $resetPasswordAction;

    public function __construct(ResetPasswordAction $resetPasswordAction)
    {
        $this->resetPasswordAction = $resetPasswordAction;
    }

    //function to send random  code to the user
    public function user_forgot_password(UserForgotPasswordRequest $request) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->resetPasswordAction->user_forgot_password($request->validated());
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to validate that the user code and the original code is the same
    public function user_check_code(UserCheckCodeRequest $request) : JsonResponse
    {
        $data = [];
        try {
                $data = $this->resetPasswordAction->user_check_code($request->validated());
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }
    }

    //function to inter the new password
    public function user_reset_password(UserResetPasswordRequest $request) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->resetPasswordAction->user_reset_password($request->validated());
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }
    }
}
