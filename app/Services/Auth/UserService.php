<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function  show_profile() : array
    {
        $user = Auth::user();
            return [
                'user' => $user,
                'message' => 'This is your information',
            ];
    }

    public function  update_profile($request) : array
    {
        $user = Auth::user();
            $user->update([
                'name' => $request['name'] ?? $user['name'],
                'email' => $request['email'] ?? $user['email'],
                'phone' => $request['phone'] ?? $user['phone'],
                'image' => $request['image'] ?? $user['image'],
                'password' => isset($request['password']) ? bcrypt($request['password']) : $user['password'],
            ]);

            return [
                'user' => $user,
                'message' => 'Updated successfully',
                'code' => 200,
            ];
    }
}
