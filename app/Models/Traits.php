<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Traits extends BaseModel
{
protected $table = 'traits';

    protected $appends = ['average'];
    public function getAverageAttribute ()
    {
        return TraitsUser::where("trait_id",$this->id)->avg('value');
    }

}
