<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Models\Metric;

class PreDefinedMetricRepository
{
    public function getOneEventPreDefinedMetric ($metric, $userId, $eventId)
    {
        $model = app(ucfirst($metric->class));
        if ($model->isWithEvent())
        {
            return $this->getOneInEventPreDefined($model, $userId,$eventId);

        } else
        {
            return $this->getOneNonEventPreDefined($model, $userId);
        }

    }
    public function getOneInEventPreDefined ($model,$userId,$eventId)
    {
        $values = $model->where('user_id',$userId)->where('event_id',$eventId)->get();
        $eventValues = [];
        foreach ($values as $value){
            if ($value->getValue() !== null)
                array_push($eventValues, $value->getValue());
        }

        return [$eventValues];
    }
    public function getOneNonEventPreDefined ($model,$userId)
    {
        $values = $model->where('user_id',$userId)->orderBy('updated_at','DESC')->first();
        $eventValues = [];
            if ($values->getValue() !== null)
                array_push($eventValues, $values->getValue());
        return [$eventValues];
    }
    public function getAllPreDefinedMetric ($metricId, $userId)
    {
        $metric = Metric::where('id', $metricId)->first();
        $model = app(ucfirst($metric->class));
        if ($model->isWithEvent())
        {
            return $this->getAllPreDefinedEventMetrics($model, $userId);

        } else
        {
            return $this->getAllPreDefinedNonEventMetrics($model, $userId);
        }

    }
    public function getAllPreDefinedEventMetrics ($model, $userId)
    {
        $eventsId = Event::where ('status',3)->pluck('id')->toArray();;
        $events = $model->whereIn("event_id",$eventsId)->where('user_id',$userId)->get()->groupBy(['event_id']);
        $arrays = [];

        foreach ($events as &$event ) {

            $eventValues = [];
            foreach ($event as $value){

                if ($value->getValue() !== null)
                    array_push($eventValues, $value->getValue());
            }
            if (count($eventValues) > 0)
                array_push($arrays,$eventValues);
        }

        return $arrays;
    }
    public function getAllPreDefinedNonEventMetrics ($model, $userId)
    {
        $values = $model->where ('user_id',$userId)->get();
        $arrays = [];
        foreach ($values as &$value ) {
            if ($value->getValue() !== null)
                array_push($arrays, [$value->getValue()]);
        }
        return $arrays;
    }
}
