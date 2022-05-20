<?php

namespace App\Models;

use App\Filters\Event\VolunteerFilter;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media', 'categories'];

    protected $appends = ['isSuperVisor', 'joinRequestStatus'];

    protected array $manyToManyRelations = ['metrics', 'categories'];

    protected array $filterables = [
        VolunteerFilter::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function metrics()
    {
        return $this->belongsToMany(Metric::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'event_category');
    }

    public function getIsSuperVisorAttribute()
    {
        if (get_class(Auth::user()) === User::class){
            $relation = EventUser::select('is_supervisor')->where('event_id', $this->id)
                ->where('user_id', Auth::id())->first();
            if ($relation)
                return $relation->is_supervisor;
        }
        return 0;
    }

    public function getJoinRequestStatusAttribute()
    {
        if (get_class(Auth::user()) === User::class){
            $relation = EventUser::select('status')->where('event_id', $this->id)
                ->where('user_id', Auth::id())->first();
            if ($relation)
                return $relation->status;
        }
        return 0;
    }

}
