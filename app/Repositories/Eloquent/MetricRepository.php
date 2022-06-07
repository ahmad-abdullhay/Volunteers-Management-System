<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Models\Metric;
use App\Models\Metric\MetricEventValue;
use App\Repositories\MetricRepositoryInterface;
use App\Services\MetricService;
use Hamcrest\Core\EveryTest;
use Illuminate\Support\Facades\Auth;


class MetricRepository extends BaseRepository implements MetricRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Metric $model
     */
    public function __construct(Metric $model)
    {
        parent::__construct($model);
    }

    public function insertMetricValue($payload)
    {
        $type = $payload['type'];

        $className = config('metric.' . $type);

        $model = resolve($className);
        $metricData = $model->create([
            'value' => $payload['value']
        ]);

        MetricEventValue::create([
            'user_id' => $payload['user_id'],
            'event_id' => $payload['event_id'],
            'metric_id' => $payload['metric_id'],
            'metric_value_type_id' => $metricData->id,
            'valuable_type' => $className
        ]);
    }

    public function getEventMetrics($event)
    {
        return $event->metrics;
    }

    public function getEventUserMetricValues($params, MetricService $metricService)
    {
        $userId = $params['user_id'];
        $eventId = $params['event_id'];
        $event = Event::where('id', $eventId)->first();
        $metricsList = [];
        foreach ($event->metrics as &$metric) {
            $valuesAndDates = $metricService->getOneEventMetricWithDate($metric->id, $userId, $eventId);

            $data = [
                "metric" => $metric,
                "values" => $valuesAndDates[0],
                "dates" => $valuesAndDates[1][0],
            ];
            array_push($metricsList, $data);
        }
        return $metricsList;
        //   return MetricEventValue::where('user_id', $userId)->where('event_id', $eventId)->get();
    }

    public function getEventUserInsertableMetrics($params)
    {
        //  return [];
        $userId = $params['user_id'];
        if (Auth::id() == $userId)
            return ["hide"];
        $eventId = $params['event_id'];
        $event = Event::where('id', $eventId)->first();
        if ($event->status != 1) {
            return [];
        }
        $metricsList = [];
        foreach ($event->metrics as &$metric) {
            if ($metric->isList($metric->type)) {
                array_push($metricsList, $metric);
            } else {
                $values = MetricEventValue::where('user_id', $userId)->where('event_id', $eventId)
                    ->where('metric_id', $metric->id)->get();
                if ($values->count() < 1) {
                    array_push($metricsList, $metric);
                }
            }
        }
        return $metricsList;
        //   return MetricEventValue::where('user_id', $userId)->where('event_id', $eventId)->get();
    }

    public function getUserMetricValues($params)
    {
        $userId = $params['user_id'];
        $eventId = $params['event_id'];

        $event = Event::select('id')->where('id',$eventId)->without(['categories', 'media', 'users'])->with(['metrics' => function($query) use($userId){
            $query->with(['values' => function($query) use ($userId){
                $query->where('user_id', $userId);
            }]);
        }])->first();

        $metricData = [];

        foreach ($event['metrics'] as $metric){
            $values = [];
            foreach ($metric['values'] as $value){
                $values[] = $value->value;
            }

            $metricData[] = [
                'name' => $metric->name,
                'type' => $metric->type,
                'values' => $values
            ];
        }

        $returnedObject = [
            'oneValue'  => [],
            'listValue' =>[]
        ];

        foreach ($metricData as $metric){
            //Check if metric is one value (Not list).

            if ($metric['type'] %2 == 1){
                array_push($returnedObject['oneValue'], $metric);
            }else{
                array_push($returnedObject['listValue'], $metric);
            }
        }
        return $returnedObject;

    }
}
