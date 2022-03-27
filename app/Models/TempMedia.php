<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TempMedia extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

}
