<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MetricRequest extends MainRequest
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
        $metric = $this->route()->metric;
        switch($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name' => 'required|unique:metrics,name',
                    'type' => 'required|integer|between:1,8'
                ];
            case 'PUT':
                return [
                    'name' => 'required|unique:metrics,name'.$metric
                ];
            default:break;
        }
        return [];
    }
}
