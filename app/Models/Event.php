<?php

namespace App\Models;

use App\Filters\Event\StatusFilter;
use App\Filters\Event\VolunteerFilter;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    const ESTABLISHING_STATUS = 0;
    const RECRUITING_STATUS = 1;
    const IN_PROGRESS_STATUS = 2;
    const ENDED_STATUS = 3;
    const ARCHIVED_STATUS = 4;
    const PAUSED_STATUS = 5;
    const ABORTED_STATUS = 6;

    protected $guarded = [];

    protected $with = ['media', 'categories', 'users'];

    protected $appends = ['isSuperVisor', 'joinRequestStatus'];

    protected array $manyToManyRelations = ['metrics', 'categories'];

    protected array $filterables = [
        VolunteerFilter::class,
        StatusFilter::class
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user')->withPivot('is_supervisor', 'status');
    }

    public function acceptedUsers()
    {
        return $this->belongsToMany(User::class)->withPivot('is_supervisor')->where('status', EventUser::ACCEPTED_STATUS);
    }

    public function supervisors()
    {
        return $this->belongsToMany(User::class)->where('status', EventUser::ACCEPTED_STATUS)->where('is_supervisor', EventUser::SUPERVISOR);
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
