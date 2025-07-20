<?php

namespace App\Http\Requests\Booking;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateBookingRequest extends FormRequest
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
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'payment_status' => ['required', 'in:0,1'],
            'guests_count' => ['required', 'integer', 'min:1'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , Response::Validation([] , $validator->errors()));
    }
}
