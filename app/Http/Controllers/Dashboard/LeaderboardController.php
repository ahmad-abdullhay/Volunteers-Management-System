<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\LeaderboardRequest;
use App\Http\Requests\LevelRequest;
use App\Http\Requests\PointRuleRequest;
use App\Models\Level;
use App\Models\Metric\Leaderboard;
use App\Services\LeaderboardService;
use App\Services\LevelService;
use App\Services\MetricQueryService;
use App\Services\PointRuleService;

class LeaderboardController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param LeaderboardService $service
     * @param LeaderboardRequest $request
     */
    public function __construct(LeaderboardService $service, LeaderboardRequest $request)
    {
        parent::__construct($service, $request);
    }

    public function tableVolunteers ()
    {
        return $this->handleSharedMessage($this->service->allTablesWithVolunteers());
    }

    public function newTable (LeaderboardRequest $request){
        return $this->service->newTable($request->post());
    }
}
