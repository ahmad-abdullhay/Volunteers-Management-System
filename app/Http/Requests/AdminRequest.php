<?php

namespace App\Http\Requests;

use App\Models\Role;

class AdminRequest extends MainRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
        $admin = $this->route()->admin;
        switch($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];

            case 'POST':
                return [
                    'name'                  => 'required',
                    'email'                 => 'required|email|unique:admins,email',
                    'password'              => 'required|confirmed|min:6',
                    'roles'                       => 'array',
                    'roles.*'                     => 'exists:roles,id'
                ];
            case 'PUT':
                return [
                    'name'                      => 'required',
                    'email'                     => 'required|email|unique:admins,email,'. $admin,
                    'password'                  => 'nullable|confirmed|min:6',
                    'roles'                     => 'array',
                    'roles.*'                   => 'exists:roles,id'
                ];
            default:break;
        }
        return [];
    }
}
