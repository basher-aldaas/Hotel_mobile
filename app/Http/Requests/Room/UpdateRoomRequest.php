<?php

namespace App\Http\Requests\Room;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRoomRequest extends FormRequest
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
            'title'       => ['nullable', 'string', 'max:255'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price'       => ['nullable', 'numeric', 'min:0'],
            'wifi'        => ['nullable', 'boolean'],
            'room_type'   => ['nullable', 'in:regular,premium,deluxe'],
            'status'      => ['nullable', 'boolean'],
            'bed_number'  => ['nullable', 'integer', 'min:1'],
            'valuation'   => ['nullable', 'numeric', 'between:0,5'],
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , Response::Validation([],$validator->errors()));
    }
}
