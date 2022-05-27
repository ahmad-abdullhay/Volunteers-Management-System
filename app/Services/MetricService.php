<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Badge;
use App\Models\Event;
use App\Models\EventMetric;
use App\Models\Metric;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricEventValue;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Repositories\Eloquent\MetricRepository;
use App\Services\Shared\BaseService;

class MetricService extends BaseService
{
    protected string $modelName = "Metric";
    protected $repository;

    public function __construct(MetricRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function insertMetricValue(array $payload)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->insertMetricValue($payload),
            true,
            null,
            200
        );
    }

    public function getEventMetrics($event)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventMetrics($event),
            true,
            null,
            200
        );
    }

    public function getEventUserMetricValues($params)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventUserMetricValues($params,$this),
            true,
            null,
            200
        );
    }
    public function getEventUserInsertableMetrics($params)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventUserInsertableMetrics($params),
            true,
            null,
            200
        );
    }
    public function getMetricEvents()
    {
        $metricId = 1;
        $userId = 1;

        return MetricEventValue::where('user_id', $userId)->where('metric_id', $metricId)->get();
    }

    //
    public function onEventEnding(Event $event, PointRuleService $pointRuleService, BadgeConditionService $badgeConditionService, BadgeService $badgeService)
    {

        $metricsList = EventMetric::where('event_id', $event->id)->get();
        // this list to store processed badge (to not process it again)
        $badgeList = [];
        foreach ($metricsList as &$metric) {
            // get all queries linked to this metric
            $queryList = MetricQuery::where('metric_id', $metric->metric_id)->get();
            foreach ($queryList as &$query) {

                // check if query is for point rule
                if ($this->pointRulesCheck($query, $pointRuleService, $event)) {
                    continue;
                }

                // check if query is for badge condition
                if ($this->badgeConditionCheck($query, $badgeList, $badgeConditionService, $badgeService, $event)) {
                    continue;
                }

            }
        }
    }

    public function pointRulesCheck($query,PointRuleService $pointRuleService, $event)
    {
        $pointRule = PointRule::where('metric_query_id', $query->id)->first();
        if ($pointRule != null) {
            $pointRuleService->apply($event, $pointRule, $query, $this);
            return true;
        }
        return false;
    }

    public function badgeConditionCheck($query, $badgeList, $badgeConditionService, $badgeService, $event)
    {
        $BadgeCondition = BadgeCondition::where('metrics_query_id', $query->id)->first();
        if ($BadgeCondition != null) {
            $badge = Badge::where('id', $BadgeCondition->badge_id)->first();
            if ($badge != null && !in_array($badge->id, $badgeList)) {
                array_push($badgeList, $badge->id);
                $badgeConditionService->apply($event, $badge, $badgeService, $this);
                return true;
            }
        }
        return false;
    }

    public function getAllEventMetric($metricId, $userId)
    {

        $metric = Metric::where('id', $metricId)->first();
        $metricType = $metric->type;
        $className = config('metric.' . $metricType);

        $metrics = MetricEventValue::select('event_id', 'metric_value_type_id', 'valuable_type')
            ->where('valuable_type', $className)
            ->where('user_id', $userId)
            ->where('metric_id', $metricId)
            ->orderBy('event_id')
            ->get()
            ->groupBy(['event_id']);

        $metricsArray = [];

        foreach ($metrics as $key => $values) {
            $array = [];
            foreach ($values as $value) {
                array_push($array, $value->value->value);
            }
            if (!empty($array))
                array_push($metricsArray, $array);
        }
        return $metricsArray;
    }

    public function getOneEventMetric($metricId, $userId, $eventId)
    {

        $metric = Metric::where('id', $metricId)->first();
        $metricType = $metric->type;
        $className = config('metric.' . $metricType);
        $metrics = MetricEventValue::select('event_id', 'metric_value_type_id', 'valuable_type')
            ->where('valuable_type', $className)
            ->where('user_id', $userId)
            ->where('metric_id', $metricId)
            ->where('event_id', $eventId)
            ->get()
            ->groupBy(['event_id']);

        $metricsArray = [];
        foreach ($metrics as $key => $values) {
            $array = [];
            foreach ($values as $value) {
                array_push($array, $value->value->value);
            }
            if (!empty($array))
                array_push($metricsArray, $array);
        }
        return $metricsArray;
    }

    public function getOneEventMetricWithDate($metricId, $userId, $eventId)
    {

        $metric = Metric::where('id', $metricId)->first();
        $metricType = $metric->type;
        $className = config('metric.' . $metricType);
        $metrics = MetricEventValue::select('event_id', 'metric_value_type_id', 'valuable_type')
            ->where('valuable_type', $className)
            ->where('user_id', $userId)
            ->where('metric_id', $metricId)
            ->where('event_id', $eventId)
            ->get()
            ->groupBy(['event_id']);

        $metricsArray = [];
        $datesArray = [];
        foreach ($metrics as $key => $values) {
            $array = [];
            $dates = [];
            foreach ($values as $value) {
                array_push($array, $value->value->value);
                array_push($dates, $value->value->created_at);
            }
            if (!empty($array)){
                array_push($metricsArray, $array);
                array_push($datesArray, $dates);
            }

        }
        return [$metricsArray,$datesArray];
    }
}
