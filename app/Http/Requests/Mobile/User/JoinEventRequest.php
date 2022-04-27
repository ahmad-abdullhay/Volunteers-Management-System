<?php

namespace App\Http\Requests\Mobile\User;

use App\Http\Requests\MainRequest;
use App\Models\EventUser;
use Illuminate\Validation\Rule;

class JoinEventRequest extends MainRequest
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
        return [
            'event_id' => [
                'exists:events,id'
            ]
        ];
    }
}
