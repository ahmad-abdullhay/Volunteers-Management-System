<?php

namespace App\Models;



// use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends BaseModel
{


    protected $guarded=[];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
