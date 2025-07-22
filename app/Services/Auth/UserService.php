<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function show_profile(): array
    {
        $user = Auth::user();

        return [
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'image' => $user->image ? asset($user->image) : null, // رابط مباشر للصورة
            ],
            'message' => 'This is your information',
        ];
    }


    public function update_profile(array $request): array
    {
        $user = Auth::user();

        $data = [
            'name'  => $request['name'] ?? $user->name,
            'email' => $request['email'] ?? $user->email,
            'phone' => $request['phone'] ?? $user->phone,
        ];

        // ✅ تحديث الصورة إذا تم رفعها
        if (isset($request['image']) && $request['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imageName = now()->format('Ymd_His') . '_' . uniqid() . '.' . $request['image']->getClientOriginalExtension();
            $request['image']->move(public_path('profile_images'), $imageName);
            $data['image'] = 'profile_images/' . $imageName;

            // ❗️(اختياري) حذف الصورة القديمة إذا كانت موجودة
            if ($user->image && file_exists(public_path($user->image))) {
                @unlink(public_path($user->image));
            }
        }

        // ✅ تحديث كلمة المرور إن وُجدت
        if (!empty($request['password'])) {
            $data['password'] = bcrypt($request['password']);
        }

        $user->update($data);

        return [
            'user'    => $user->fresh(), // بيانات جديدة بعد التحديث
            'message' => 'Updated successfully',
            'code'    => 200,
        ];
    }
}
