<?php

namespace App\Models;

class EventCategory extends BaseModel
{
    protected $table = 'event_category';

    public $timestamps = false;
    protected $with = ['traits'];

    public function traits (){
        return $this->hasMany(Traits::class);
    }

}
