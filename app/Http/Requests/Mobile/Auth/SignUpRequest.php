<?php

namespace App\Http\Requests\Mobile\Auth;

use App\Http\Requests\MainRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class SignUpRequest extends MainRequest
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
            'phone' => [
                'required',
                Rule::exists('users', 'phone')
                    ->where('is_active', User::ACTIVE_STATUS),
                ]
        ];
    }
}
