<?php

namespace App\Http\Requests\Offer;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateOfferRequest extends FormRequest
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
            'title'       => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'discount'    => ['sometimes', 'numeric', 'between:0,100'],
            'start_date'  => ['sometimes', 'date', 'after_or_equal:today'],
            'end_date'    => ['sometimes', 'date', 'after:start_date'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , Response::Validation([],$validator->errors()));
    }
}
