<?php

namespace App\Http\Controllers\Dashboard\Badge;

use App\Common\SharedMessage;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Http\Requests\Badge\AddBadgeUserRequest;
use App\Http\Requests\Badge\BadgeRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\PointRuleRequest;
use App\Models\Metric\PointRule;
use App\Services\BadgeConditionService;
use App\Services\BadgeService;
use App\Services\EventService;
use App\Services\MetricQueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;

class BadgeController extends BaseController
{
    private BadgeService $service;

    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param BadgeService $service
     */
    public function __construct(BadgeService $service)
    {
        $this->service = $service;
    }

    public function addBadgeUser(AddBadgeUserRequest $payload){
        return $this->handleSharedMessage($this->service->addBadgeToUser($payload->post()));
    }

    public function newBadge (BadgeRequest $request,MetricQueryService $metricQueryService,BadgeConditionService
    $badgeConditionService){

        $this->service->createBadge($request,$metricQueryService,$badgeConditionService);
    }

    public function getAll (){
       return $this->service->getAll();

    }

    public function index(Request $request)
    {
        $filters = $request->query();

        return $this->handleSharedMessage(
            $this->service->index(
                ['*'],
                [],
                $request->per_page ?? 10,
                $request->sort_keys ?? ['id'],
                $request->sort_dir ?? ['desc'],
                $filters,
                $request->search ?? null
            )
        );
    }
}
