<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MetricQueryRequest;
use App\Services\MetricQueryService;

class MetricQueryController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param MetricQueryService $service
     * @param MetricQueryRequest $request
     */
    public function __construct(MetricQueryService $service, MetricQueryRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    public function getMetricsOperations()
    {

        return
            [
                [
                    "type" => 1,
                    "operations" => [

                    ],
                    "compareOperations" => [
                        ['id' => 'isTrue', 'label' => 'metric is true','hasValue'=>false],
                        ['id' => 'isFalse', 'label' => 'metric is false','hasValue'=>false]
                    ],
                ],

                [
                    "type" => 2,
                    "operations" => [
                        ['id' => 'mostTrue', 'label' => 'most is true', 'to' => '1'],
                        ['id' => 'mostFalse', 'label' => 'most is false', 'to' => '1'],
                     //   ['id' => 'most', 'label' => 'most value in metric', 'to' => '1'],
                        ['id' => 'trueCount', 'label' => 'true count', 'to' => '5'],
                        ['id' => 'falseCount', 'label' => 'false count', 'to' => '5'],
                        ['id' => 'allTrue', 'label' => 'all is true', 'to' => '1'],
                        ['id' => 'allFalse', 'label' => 'all is false', 'to' => '1'],
                        ['id' => 'count', 'label' => 'values count', 'to' => '5'],
                    ],
                    "compareOperations" => [],
                ],
                [
                    "type" => 3,
                    "operations" => [],
                    "compareOperations" => [],
                ],
                [
                    "type" => 4,
                    "operations" => [
                        ['id' => 'count', 'label' => 'values count', 'to' => '5'],
                    ],
                    "compareOperations" => [],
                ],
                [
                    "type" => 5,
                    "operations" => [],
                    "compareOperations" => [
                        ['id' => 'more', 'label' => 'metric is more than','hasValue'=>true],
                        ['id' => 'less', 'label' => 'metric is less than','hasValue'=>true],
                        ['id' => 'equal', 'label' => 'metric is equal','hasValue'=>true]
                    ],
                ],
                [
                    "type" => 6,
                    "operations" => [
                        ['id' => 'min', 'label' => 'min value', 'to' => '5'],
                        ['id' => 'max', 'label' => 'max value', 'to' => '5'],
                        ['id' => 'avg', 'label' => 'values average', 'to' => '5'],
                        ['id' => 'sum', 'label' => 'values sum', 'to' => '5'],
                        ['id' => 'count', 'label' => 'values count', 'to' => '5'],
                    ],
                    "compareOperations" => [],
                ],
                [
                    "type" => 7,
                    "operations" => [],
                    "compareOperations" => [
                        ['id' => 'equal', 'label' => 'metric is equal','hasValue'=>true]
                    ],
                ],
                [
                    "type" => 8,
                    "operations" => [
                        ['id' => 'enumMost', 'label' => 'values sum', 'to' => '7'],
                        ['id' => 'count', 'label' => 'values count', 'to' => '5'],
                    ],
                    "compareOperations" => [],
                ],
            ];
    }
}
