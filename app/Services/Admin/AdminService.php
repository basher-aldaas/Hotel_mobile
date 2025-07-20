<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    public function  show_special_user_profile($id) : array
    {
        $user = User::find($id);

        if ($user){
            $data = $user;
            $code = 200;
            $message = 'This is your information';
        }
        return [
            'data' => $data ?? null,
            'message' => $message ?? 'not found',
            'code' => $code ?? 404,
        ];
    }

    public function show_user($id) : array
    {
        $user = User::query()->where('id' , $id)->first();
        if ($user){
            $data = $user;
            $message = 'Getting user successfully';
            $code = 200;
        }
        return [
            'data' => $data ?? null,
            'message' => $message ?? 'not found',
            'code' => $code ?? 404,
        ];
    }

    public function show_users() : array
    {
        $users = User::all();
        if ($users){
            $data = $users;
            $message = 'Getting all users successfully';
            $code = 200;
        }

        return [
            'data' => $data ?? null,
            'message' => $message ?? 'not found',
            'code' => $code ?? 404,
        ];
    }

    public function delete_user($id) : array
    {
        $user = User::query()->where('id' , $id)->first();
        if ($user){
            $user->delete();
            $message = 'Delete user successfully';
            $code = 200;
        }

        return [
            'data' => [],
            'message' => $message ?? 'not found',
            'code' => $code ?? 404,
        ];
    }

}
