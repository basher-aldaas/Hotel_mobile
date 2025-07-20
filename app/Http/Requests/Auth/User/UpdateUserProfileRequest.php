<?php

namespace App\Http\Requests\Auth\User;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = auth()->id(); // للحصول على معرف المستخدم الحالي

        return [
            'name'     => ['nullable', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255', 'unique:users,email,' . $userId],
            'phone'    => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $userId],
            'password' => ['nullable', 'string', 'min:8'], // تأكد من وجود حقل password_confirmation
            'image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2MB كحد أقصى
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , Response::Validation([],$validator->errors()));
    }
}
