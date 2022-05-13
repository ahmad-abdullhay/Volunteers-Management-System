<?php

namespace App\Models;



use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    protected $with = ['media'];

    protected $guarded=[];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
