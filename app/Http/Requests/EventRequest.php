<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class EventRequest extends MainRequest
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
            case 'PUT':
            case 'POST':
                return [
                    'name'                          => 'required|string',
                    'description'                   => 'required|string',
                    'start_date'                    => 'required|date',
                    'required_volunteers_number'    => 'required|integer',
                    'end_date'                      => 'required|date|after:start_date',
                    'users'                         => 'array',
                    'users.*'                       => [
                        Rule::exists('users', 'id')
                            ->where('is_active', User::ACTIVE_STATUS),
                    ],
                    'metrics'                       => 'array',
                    'metrics.*'                     => 'exists:metrics,id'
                ];
            default:break;
        }
        return [];
    }
}
