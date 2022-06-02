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
            "isTrue" => $this->isTrue($compareValue),
            "isFalse" => $this->isFalse($compareValue),
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
    public function isTrue($compareValue)
    {

        return $compareValue == 1;
    }
    public function isFalse($compareValue)
    {
        return $compareValue == 0;
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
            "allTrue" => $this->allTrue($valueList),
            "allFalse" => $this->allFalse($valueList),
            "trueCount" => $this->trueCount($valueList),
            "falseCount" => $this->falseCount($valueList),
            "mostFalse" => $this->mostFalse($valueList),
            "mostTrue" => $this->mostTrue($valueList),
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
    public function allTrue($valueList)
    {

        foreach ($valueList as &$value){
            if ($value === 0)
                return false;
        }

        return true;
    }

    public function allFalse($valueList)
    {
        foreach ($valueList as &$value){
            if ($value == 1)
                return false;
        }
        return true;
    }
    public function trueCount ($valueList){
        $counter = 0;
        foreach ($valueList as &$value){
            if ($value == 1)
                $counter++;
        }
        return $counter;
    }
    public function falseCount ($valueList){
        $counter = 0;
        foreach ($valueList as &$value){
            if ($value == 0)
                $counter++;
        }
        return $counter;
    }
    public function mostTrue ($valueList){

          return  $this->trueCount($valueList) > ($this->countArray($valueList)/2);
    }
    public function mostFalse ($valueList){
        return  $this->falseCount($valueList) > ($this->countArray($valueList)/2);
    }
}
