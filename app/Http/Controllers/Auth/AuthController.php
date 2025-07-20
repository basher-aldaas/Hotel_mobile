<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\sign\UserLoginRequest;
use App\Http\Requests\Auth\sign\UserRegisterRequest;
use App\Http\Responses\Response;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    //function to register the new user
    public function register(UserRegisterRequest $request) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->authService->register($request->validated());
            return Response::Success($data['user'] , $data['message']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }
    }

    //function to log in user
    public function login(UserLoginRequest $request) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->authService->login($request->validated());
            return Response::Success($data['user'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to log out user
    public function logout() : JsonResponse
    {
        $data = [];
        try {
                $data = $this->authService->logout();
                return Response::Success($data['user'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }
    }
}
