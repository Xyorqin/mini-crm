<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Illuminate\Foundation\Http\FormRequest;

class BuyProductRequest extends ParentRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'provider_id'   => 'required|integer',
            'refund'        => 'nullable|boolean',
            'date'          => 'nullable|date',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity'   => 'required|integer',
            'products.*.price'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'products.*.batch_id'   => 'required|integer',
        ];
    }
}
