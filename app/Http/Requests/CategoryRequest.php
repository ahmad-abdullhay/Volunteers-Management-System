<?php

namespace App\Http\Requests;

class CategoryRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
                return [
                    'name'                          => 'required|string',
                    'description'                   => 'string',
                ];
            default:break;
        }
        return [];
    }
}
