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
                    B
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
