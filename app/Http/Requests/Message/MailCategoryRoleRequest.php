<?php

namespace App\Http\Requests\Message;



use App\Http\Requests\MainRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class MailCategoryRoleRequest extends MainRequest
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

            case 'POST':
                return [
                    'type'                          => 'required|string',
                    'role_id'                   =>  [Rule::exists('roles', 'id')],
                    'mail_category_id' => [Rule::exists('mail_categories', 'id')],
                ];
            default:break;
        }
        return [];
    }
}
