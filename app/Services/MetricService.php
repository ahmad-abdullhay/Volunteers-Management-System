<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Badge;
use App\Models\Event;
use App\Models\EventMetric;
use App\Models\Metric;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\EventPointStats;
use App\Models\Metric\MetricEventValue;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Models\PreMetric;
use App\Models\Questionnaire;
use App\Models\User;
use App\Repositories\Eloquent\MetricRepository;
use App\Repositories\Eloquent\PreDefinedMetricRepository;
use App\Services\Shared\BaseService;

class MetricService extends BaseService
{
    protected string $modelName = "Metric";
    protected $repository;
    protected MetricOperations $metricOperations;
    protected PreDefinedMetricRepository $preDefinedMetricRepository;
protected PointRuleService $pointRuleService;
protected  BadgeConditionService $badgeConditionService;
protected BadgeService $badgeService;
    public function __construct(MetricRepository $repository,MetricOperations $metricOperations,
                                PreDefinedMetricRepository $preDefinedMetricRepository,PointRuleService $pointRuleService,
                                BadgeConditionService $badgeConditionService, BadgeService $badgeService)
    {
        $this->metricOperations = $metricOperations;
        $this->repository = $repository;
        $this->preDefinedMetricRepository =$preDefinedMetricRepository;
        $this->pointRuleService =$pointRuleService;
        $this->badgeConditionService =$badgeConditionService;
        $this->badgeService =$badgeService;
        parent::__construct($repository);
    }
    public function store($payload): SharedMessage
    {
        if (isset($payload['enums'])) {

            $enums = $payload['enums'];

            unset($payload['enums']);


            $metric = $this->repository->create($payload);

            $this->repository->attachEnums(
                $metric,
                $enums,
            );

            return new SharedMessage(__('success.store', ['model' => $this->modelName]),
                $metric->fresh(),
                true,
                null,
                200
            );
        }


        return parent::store($payload);
    }
    public function insertMetricValue(array $payload,EventMetricConfigurationService $configurationService)
    {
        $validation =   $configurationService->isValid($payload,$this);
        if ($validation === true){
            return new SharedMessage(__('success.store', ['model' => $this->modelName]),
                $this->repository->insertMetricValue($payload),
                true,
                null,
                200
            );
        } else {
            return new SharedMessage(__($validation), [], false, 200
           );
        }



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
    public function getEventMetricsWithConfiguration($event)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getEventMetricsWithConfiguration($event),
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
    public function onQuestionnaireFilling(Questionnaire $questionnaire, )
    {

        $metricsList = Metric::where('class', "App\Models\QuestionnaireUser")->get();

        // this list to store processed badge (to not process it again)
        $badgeList = [];
        foreach ($metricsList as &$metric) {

            // get all queries linked to this metric
            $queryList = MetricQuery::where('metric_id', $metric->id)->get();

            foreach ($queryList as &$query) {

                // check if query is for point rule
                if ($this->pointRulesCheck($query, $this->pointRuleService, null)) {
                    continue;
                }

                // check if query is for badge condition
                if ($this->badgeConditionCheck($query, $badgeList, $this->badgeConditionService, $this->badgeService, null)) {
                    continue;
                }

            }
        }
        return null;
    }

    public function pointRulesCheck($query,PointRuleService $pointRuleService, $event)
    {
        $pointRule = PointRule::where('metrics_query_id', $query->id)->first();
        $myfile = fopen("pre.txt", "w") or die("Unable to open file!");
        $myJSON=json_encode($pointRule);
        fwrite($myfile, $myJSON);
        fclose($myfile);
        if ($pointRule != null) {
            if ($event == null){
                $pointRuleService->applyNonEvent( $pointRule, $query, $this);
            } else {
                $pointRuleService->apply($event, $pointRule, $query, $this);
            }
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
                if ($event != null){
                    $badgeConditionService->apply($event, $badge, $badgeService, $this);
                } else {
                    $badgeConditionService->applyNonEvent( $badge, $badgeService, $this);
                }

                return true;
            }
        }
        return false;
    }
    public function eventPointsStatCalculate (Event  $event)
    {
        $userPoints =
        UserPoint::Where('event_id', $event->id)
            ->selectRaw("SUM(points) as sum,user_id")
            ->groupBy('user_id')
            ->get();
        foreach ($userPoints as $userP)
        {
            $userTotalPoints = Metric\UserTotalPoints::where('user_id',$userP->user_id)->first();
            $stats = new EventPointStats;
            $stats->points_before =$userTotalPoints->total_points - $userP->sum;
            $stats->points_added = $userP->sum;
            $stats->user_id = $userP->user_id;
            $stats->event_id = $event->id;
            $stats->save();
        }

    }
    public function allEventOperation ($query,$user){
        $valuesListList = $this->getAllEventMetric($query->metric_id,$user->id);
        $json = json_encode(array('data' => $valuesListList));
        file_put_contents("data.json", $json);
        if (empty($valuesListList))
            return null;
        // do first operation for inners arrays
        $resultList = [];
        foreach ($valuesListList as &$valueList) {
            $result = $this->metricOperations->doOperation($query->first_operation, $valueList);
            array_push($resultList, $result);
        }
        // do second operation for outer array (results array)
        $finalResult = $this->metricOperations->doOperation($query->second_operation, $resultList);

        return $finalResult;
    }

    public function getAllEventMetric($metricId, $userId)
    {

        $metric = Metric::where('id', $metricId)->first();
        if ($metric->class != null){

                return $this->preDefinedMetricRepository->getAllPreDefinedMetric($metric->id,$userId);
        }
        $metricType = $metric->type;
        $className = config('metric.' . $metricType);
        $eventsId = Event::where ('status',3)->pluck('id')->toArray();;

        $metrics = MetricEventValue::select('event_id', 'metric_value_type_id', 'valuable_type')
            ->whereIn("event_id",$eventsId)
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
        if ($metric->class != null){
            return $this->preDefinedMetricRepository->getOneEventPreDefinedMetric($metric,$userId, $eventId);
        }
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

    public function getUserMetricValues($params)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->getUserMetricValues($params),
            true,
            null,
            200
        );
    }
}
