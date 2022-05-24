<?php

namespace App\Http\Requests;



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
                    'mail_category_id' => [Rule::exists('mail_categories', 'id')]
                ];
            default:break;
        }
        return [];
    }
}
