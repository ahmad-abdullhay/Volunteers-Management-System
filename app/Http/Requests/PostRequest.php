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
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
                return [
                    'title'                          => 'required|string',
                    'text'                   => 'required|string',
                    'user_id'                    => 'required|integer',
                    'status'    => 'required|string'
                ];
            default:break;
        }
        return [];
    }
}
