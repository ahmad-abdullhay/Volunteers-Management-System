<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends MainRequest
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
        $role = $this->route()->role;
        switch($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name' => 'required|unique:roles,name',
                    'permissions.*' => 'exists:permissions,id'
                ];
            case 'PUT':
                return [
                    'name' => 'required|unique:roles,name,'.$role,
                    'permissions.*' => 'exists:permissions,id'
                ];
            default:break;
        }
        return [];
    }
}
