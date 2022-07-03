<?php

namespace App\Http\Requests;

class QuestionnaireRequest extends MainRequest
{
    public function authorize()
    {
        return true;
    }
}
