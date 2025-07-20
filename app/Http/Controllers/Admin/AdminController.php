<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\Response;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    //function to get user information
    public function show_special_user_profile($id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->adminService->show_special_user_profile($id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to show special user
    public function show_user($id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->adminService->show_user($id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to show all users
    public function show_users() :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->adminService->show_users();
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to delete special user
    public function delete_user($id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->adminService->delete_user($id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }


}
