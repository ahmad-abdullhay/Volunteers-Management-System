<?php

namespace App\Filters\Notification;

use App\Filters\Interfaces\Filter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter implements Filter
{
    public string $column = "user_id";

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
            $builder->where('user_id', $value);
        }
    }
}
