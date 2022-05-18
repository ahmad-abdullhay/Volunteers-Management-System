<?php

namespace App\Filters\Post;

use App\Filters\Interfaces\Filter;
use Illuminate\Database\Eloquent\Builder;

class PostFilter implements Filter
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
        $value = $filters[$this->column] ?? null;

        if ($value !== null){
            //Apply suitable filter for this value.
            $builder->whereHas('users', function ($query) use ($value){
               $query->where('user_id', $value);
            });
        }
    }
}
