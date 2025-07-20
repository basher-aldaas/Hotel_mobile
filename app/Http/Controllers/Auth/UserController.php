<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\UpdateUserProfileRequest;
use App\Http\Responses\Response;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    //function to get user information
    public function show_profile() :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->userService->show_profile();
                return Response::Success($data['user'] , $data['message']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to update user information
    public function update_profile(UpdateUserProfileRequest $request) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->userService->update_profile($request->validated());
                return Response::Success($data['user'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }
}
