<?php

namespace App\Http\Requests;


class PostRequest extends MainRequest
{

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
            case 'PUT':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'title'                          => 'required|string',
                    'text'                   => 'required|string',
                    'status'    => 'required|string'
                ];
            default:break;
        }
        return [];
    }
}
