<?php

namespace App\Services\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthService
{
    public function register($request) : array
    {
        $user = User::query()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'image' => $request['image'] ?? null,
            'password' => bcrypt($request['password']),
        ]);

        $userRole = Role::query()->where('name' , 'user')->first();

        $user->assignRole($userRole);
        $permissions = $userRole->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        $user->load('roles', 'permissions');

       //$user = User::query()->find($user['id']);
        //$user = $this->appendRolesAndPermissions($user);
        $user['token'] = $user->createToken("token")->plainTextToken;

        return [
            'user' => $user,
            'message' => __('Your account created successfully'),
        ];
    }

    public function login($request) : array
    {
        $user = User::query()->where('email' , $request['email'])
            ->first();
        if (!is_null($user)){
                if (Auth::attempt(['email' => $request['email'] , 'password' => $request['password']])){
                    $user = $this->appendRolesAndPermissions($user);
                    $user['token'] = $user->createToken("token")->plainTextToken;
                    $message = 'You are logged successfully';
                    $code = 200;
                }else{
                    $user = [];
                    $message = 'User email does not match with password';
                    $code = 401;
                }
        }else{
            $user = [];
            $message = 'User not found you must to register first';
            $code = 404;
        }
        return [

            'user' => $user,
            'message' => $message,
            'code' => $code,
        ];
    }

    public function logout() : array
    {
        $user = Auth::user();
        if (!is_null($user)){
            Auth::user()->currentAccessToken()->delete();
            $message = 'Logged out successfully';
            $code = 200;
        }else{
            $user = [];
            $message = 'Invalid Token';
            $code = 404;
        }
        return [
            'user' => $user,
            'message' => $message,
            'code' => $code,
        ];
    }

    //اضافة الصلاحيات والاذونات لكل مستخدم يدخل
    //مهمتها انو تحذف الادوار والصلاحيات القديمة وتعطي ادوار وصلاحيات جديدة
    public function appendRolesAndPermissions($user)
    {
        $roles=[];
        foreach ($user->roles as $role){
            $roles []= $role->name;
        }
        unset($user['roles']);
        $user['roles']=$roles;

        $permissions=[];
        foreach ($user->permissions as $permission) {
            $permissions [] =$permission->name;
        }

        unset($user['permissions']);
        $user['permissions']=$permissions;

        return $user;

    }

}
