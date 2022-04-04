<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JoinRequestRequest extends MainRequest
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
        $user = $this->route()->user;
        switch($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name'                  => 'required',
                    'username'              => 'required|unique:users,username',
                    'email'                 => 'required|email|unique:users,email',
                    'date_of_birth'         => 'required',
                    'phone'                 => 'required|unique:users,phone',
                    'gender'                => 'required|integer|between:1,2',
                    'location'              => 'required|string',
                    'job'                   => 'required|string',
                    'volunteering_history'  => 'string'

                ];
            case 'PUT':
                return [
                    'name' => 'required|unique:users,name'.$user,
                    'permissions.*' => 'exists:permissions,id'
                ];
            default:break;
        }
        return [];
    }
}
