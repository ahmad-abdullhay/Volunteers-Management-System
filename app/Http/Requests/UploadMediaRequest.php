<?php

namespace App\Http\Requests;

class UploadMediaRequest extends MainRequest
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
            'files' => ['required'],
            'files.*' => ['mimes:jpg,jpeg,png,mp4,pdf']
        ];
    }
}
