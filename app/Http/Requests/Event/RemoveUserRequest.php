<?php

namespace App\Http\Requests\Event;


use App\Http\Requests\MainRequest;

class RemoveUserRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'user_id' => 'required',
          'event_id' => 'required|exists:events,id'
        ];
    }
}
