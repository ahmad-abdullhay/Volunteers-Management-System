<?php

namespace App\Services;

use App\Services\Shared\BaseService;

class MetricOperations
{
    public function __construct()
    {
        //parent::__construct();
    }
    public function doCompare ($operation, $compareValue,$value){
        return match ($operation) {
            "equal" => $this->equal($compareValue,$value),
            "more" => $this->more($compareValue,$value),
            "less" => $this->less($compareValue,$value),
            default => null,
        };
     //  $result = $this->doOperation()
    }

    public function equal($compareValue,$value)
    {
        return $compareValue == $value;
    }

    public function more($compareValue,$value)
    {
        return $compareValue > $value;
    }

    public function less($compareValue,$value)
    {
        return $compareValue < $value;
    }


    public function doOperation($operation, $valueList)
    {
        return match ($operation) {
            "sum" => $this->sumArray($valueList),
            "false sum" => $this->falseSumArray($valueList),
            "avg" => $this->averageArray($valueList),
            "count" => $this->countArray($valueList),
            "max" => $this->maxArray($valueList),
            "min" => $this->minArray($valueList),
            default => null,
        };
    }
    // sum int
    //  sum true
    public function sumArray($valueList)
    {
        return array_sum($valueList);
    }

    public function falseSumArray($valueList)
    {
        return $this->countArray($valueList) - $this->sumArray($valueList);
    }

    public function countArray($valueList)
    {
        return count($valueList);
    }

    public function averageArray ($valueList){
        return   $this->sumArray($valueList) / $this->countArray($valueList);
    }

    public function maxArray($valueList)
    {
        return max($valueList);
    }

    public function minArray($valueList)
    {
        return min($valueList);
    }

}
