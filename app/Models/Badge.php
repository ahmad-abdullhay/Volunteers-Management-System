<?php

namespace App\Models;

use App\Filters\Badge\BadgeFilter;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricQuery;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Badge extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $appends = ['isTaken'];


    protected $with = ['media'];
    protected array $filterables = [
        BadgeFilter::class,
    ];


    protected array $manyToManyRelations = ['users'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function badgeCondition() {
        return $this->hasMany(BadgeCondition::class,'badge_id','id');
    }
    public function getIsTakenAttribute()
    {
        if (get_class(Auth::user()) === User::class){
            $relation = BadgeUser::query()->where('badge_id', $this->id)
                ->where('user_id', Auth::id())->first();
            if ($relation)
                return 1;
        }
        return 0;
    }
}
