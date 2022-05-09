<?php

namespace App\Filters\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param array $filters
     */
    public  function apply(Builder &$builder, array $filters);
}
