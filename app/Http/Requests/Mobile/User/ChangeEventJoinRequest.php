<?php

namespace App\Http\Requests\Mobile\User;

use App\Http\Requests\MainRequest;
use App\Models\EventUser;
use Illuminate\Validation\Rule;

class ChangeEventJoinRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $relation = EventUser::where('event_id', $this->event_id)
                        ->where('user_id', $this->user()->id)->first();

        if($relation && $relation->is_supervisor === EventUser::SUPERVISOR){
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status'     => [
                'required',
                Rule::in([0, 1])],
            'users'     => ['required'],
            'users.*'   => [
                'exists:users,id'
            ],
            'event_id' => [
                'exists:events,id'
            ]
        ];
    }
}
