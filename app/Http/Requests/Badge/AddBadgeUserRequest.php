<?php

namespace App\Http\Requests\Badge;


use App\Http\Requests\MainRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class AddBadgeUserRequest extends MainRequest
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
            'user_id'  => "integer",
            'badge_id'  => [Rule::exists('badges', 'id')],
            'note'  => 'string'

        ];
    }
}
