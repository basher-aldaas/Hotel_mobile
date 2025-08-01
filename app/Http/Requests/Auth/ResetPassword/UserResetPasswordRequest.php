<?php

namespace App\Http\Requests\Auth\ResetPassword;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserResetPasswordRequest extends FormRequest
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
        return [
            'code' => ['required' , 'string' , 'exists:reset_code_passwords'],
            'password' => ['required' , 'confirmed' , 'min:8'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , Response::Validation([] , $validator->errors()));
    }
}
