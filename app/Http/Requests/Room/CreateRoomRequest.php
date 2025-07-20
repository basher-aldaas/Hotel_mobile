<?php

namespace App\Http\Requests\Room;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateRoomRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'wifi' => ['required', 'boolean'],
            'room_type' => ['required', 'in:regular,premium,deluxe'],
            'status' => ['nullable', 'boolean'],
            'bed_number' => ['required', 'integer', 'min:1'],
            'valuation' => ['nullable', 'numeric', 'between:0,5'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , Response::Validation([],$validator->errors()));
    }
}
