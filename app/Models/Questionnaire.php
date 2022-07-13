<?php

namespace App\Models;

class Questionnaire extends BaseModel
{
    protected $table = 'questionnaires';
    protected $with = ['questions','inventories'];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function questionnaireUsers()
    {
        return $this->hasMany(QuestionnaireUser::class);
    }

    public function inventories()
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }

    protected $guarded = [];
}

