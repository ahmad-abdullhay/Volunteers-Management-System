<?php

namespace App\Http\Requests\Mobile\Notification;

use App\Http\Requests\MainRequest;

class ReadNotificationsRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notifications'   => 'required|array',
            'notifications.*' =>  'exists:notifications,id'
        ];
    }
}
