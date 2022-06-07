<?php

namespace App\Http\Requests\Message;



use App\Http\Requests\MainRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Validation\Rule;

class MailRequest extends MainRequest
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
                    'title'                          => 'required|string',
                    'text'                   => 'required|string',
                    'mail_category_id' => [Rule::exists('mail_categories', 'id')],
                    'users'                         => 'array',
                    'users.*'                       => [
                        Rule::exists('users', 'id')
                            ->where('is_active', User::ACTIVE_STATUS),
                    ],
                    'admins'                         => 'array',
                    'admins.*'                       => [
                        Rule::exists('admins', 'id')
//                            ->where('is_active', Admin::ACTIVE_STATUS),
                    ],
                ];
            default:break;
        }
        return [];
    }
}
