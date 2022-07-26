<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Requests\QuestionnaireRequest;
use App\Services\GamificationStatsService;
use App\Services\QuestionnaireService;
use App\Services\VolunteeringCenterService;

class VolunteeringCenterController
{
protected VolunteeringCenterService $service;
    protected GamificationStatsService $gamificationStatsService;
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param VolunteeringCenterService $service
     */

    public function __construct(VolunteeringCenterService $service,GamificationStatsService $gamificationStatsService)
    {
        $this->service = $service;
        $this->gamificationStatsService = $gamificationStatsService;
    }

    public function getEventUserStats ()
    {
   return $this->service->getEventUserStats ();
    }
    public function getUserGamificationStats ()
    {
        return $this->gamificationStatsService->getGamificationStats();
    }

}
