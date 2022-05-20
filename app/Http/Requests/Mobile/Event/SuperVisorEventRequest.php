<?php

namespace App\Http\Requests\Mobile\Event;

use App\Http\Requests\MainRequest;
use App\Models\EventUser;
use Illuminate\Support\Facades\Auth;

class SuperVisorEventRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $relation = EventUser::where('event_id', $this->event->id)
            ->where('user_id', $this->user()->id)->first();

        if($relation && $relation->is_supervisor === EventUser::SUPERVISOR){
            return true;
        }

        return false;
    }
}
