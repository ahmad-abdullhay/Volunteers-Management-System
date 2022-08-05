<?php

namespace App\Models;

class EventCategory extends BaseModel
{
    protected $table = 'event_category';

    public $timestamps = false;
    protected $appends = ['traits'];
    public function getTraitsAttribute (){
        return CategoryTraits::where("category_id",$this->id)->get();
    }

}
