<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $guarded = [];
    protected $appends = ['traits'];

    public function getTraitsAttribute (){
        return CategoryTraits::where("category_id",$this->id)->get();
    }


}
