<?php

namespace App\Models;

class Inventory extends BaseModel
{
    protected $table = 'inventories';
    protected $with = ['traits'];

    public function traits (){
        return $this->hasMany(Traits::class);
    }

}
