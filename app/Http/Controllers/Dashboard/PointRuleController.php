<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MetricQueryRequest;
use App\Http\Requests\PointRuleRequest;
use App\Repositories\Eloquent\PointRuleRepository;
use App\Services\MetricQueryService;
use App\Services\PointRuleService;

class PointRuleController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param PointRuleService $service
     * @param PointRuleRequest $request
     */
    public function __construct(PointRuleService $service, PointRuleRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param PointRuleService $service
     * @param PointRuleRequest $request
     */
    public function newPointRule (PointRuleService $service, PointRuleRequest $request,MetricQueryService $metricQueryService){
       return $service->newPointRule($request->post(),$metricQueryService);

    }

    public function getAll (){
       return $this->service->getAll();
    }
}

