<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class MainRequest extends FormRequest
{

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        // Check on accept key in the header of the request.
        if (request()->header('accept') !== 'application/json'){
            // Call on parent logic.
            parent::failedValidation($validator);
        } else {
            // Throw exceptions.
            throw new HttpResponseException(
                response()->json([
                    'message' => '',
                    'status' => false,
                    'data' => [],
                    'errors' => $validator->messages()->all(),
                    'status_code' => JsonResponse::HTTP_BAD_REQUEST
                ], 422)
            );
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
