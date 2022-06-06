<?php

namespace App\Filters\Event;

use App\Filters\Interfaces\Filter;
use App\Models\EventUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VolunteerFilter implements Filter
{
    public string $column = "myEvents";

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param array $filters
     */
    public function apply(Builder &$builder, array $filters)
    {
        $value =isset($filters[$this->column])? $filters[$this->column]: null;

        if ($value !== null){
            //Apply suitable filter for this value.
            if ($value == "true")
                $builder->whereHas('users', function ($query){
                   $query->where('user_id', Auth::id())->where('status', EventUser::ACCEPTED_STATUS);
                });
            else if ($value == "false")
                $builder->whereHas('users', function ($query){
                    $query->where('user_id', Auth::id())->where('status', '!=', EventUser::ACCEPTED_STATUS)
                        ->orWhere('user_id', '!=', Auth::id());
                });
        }
    }
}
