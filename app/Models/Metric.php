<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metric extends BaseModel
{
    use HasFactory;

    const BOOLEAN_TYPE = 1;
    const BOOLEAN_LIST_TYPE = 2;
    const STRING_TYPE = 3;
    const STRING_LIST_TYPE = 4;
    const INTEGER_TYPE = 5;
    const INTEGER_LIST_TYPE = 6;

    protected $guarded = [];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
