<?php

namespace App\Filters\Event;

use App\Filters\Interfaces\Filter;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter implements Filter
{
    public string $column = "status";

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
            if ($value[0] == '!'){
//                $myfile = fopen("more.txt", "w") or die("Unable to open file!");
//                $myJSON=json_encode($value);
//                fwrite($myfile, $myJSON);
//                fclose($myfile);
                $builder->where('status','!=', $value[1]);
            } else {
                $builder->where('status', $value);
            }
            //Apply suitable filter for this value.

        }
    }
}
