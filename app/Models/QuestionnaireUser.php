<?php

namespace App\Models;

class QuestionnaireUser extends BaseModel implements PreMetric
{
    protected $table = 'questionnaires_users';

    public function getValue()
    {
        return $this->is_done;
    }

   static public function isWithEvent(): bool
   {
        return false;
    }
}
