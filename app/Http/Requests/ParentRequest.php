<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ErrorResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ParentRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        return throw new HttpResponseException(
            response()->json([
                'result' => [
                    'success' => false,
                    'data'     => []
                ],
                'error' => [
                    'message' => __('messages.validation_error'),
                    'code'    => 422
                ],
                'validation_errors' => $errors,
            ])->setStatusCode(422)
        );
      
    }
   
}
