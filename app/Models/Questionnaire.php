<?php

namespace App\Models;

class Questionnaire extends BaseModel
{
    protected $table = 'questionnaires';
    protected $with = ['questions'];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function questionnaireUsers()
    {
        return $this->hasMany(QuestionnaireUser::class);
    }
    protected $guarded = [];
}

