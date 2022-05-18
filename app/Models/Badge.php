<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Badge extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];


    protected array $manyToManyRelations = ['users'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
