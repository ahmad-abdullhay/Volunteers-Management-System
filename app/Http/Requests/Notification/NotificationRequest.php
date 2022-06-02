<?php

namespace App\Http\Requests\Notification;


use App\Http\Requests\MainRequest;

class NotificationRequest extends MainRequest
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
                    'user_id'           => 'required|string|exists:users,id',
                    'content'           => 'required|string',
                ];
            default:break;
        }
        return [];
    }
}
