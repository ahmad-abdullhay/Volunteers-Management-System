<?php

namespace App\Models;

class Event extends BaseModel
{
    protected $guarded = [];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
