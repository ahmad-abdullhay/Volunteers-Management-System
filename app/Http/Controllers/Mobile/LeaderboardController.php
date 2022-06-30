<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Models\Metric\Leaderboard;
use App\Services\LeaderboardService;
use App\Services\MetricService;

class LeaderboardController extends BaseController
{
    protected LeaderboardService $leaderboardService;
    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }

    public function tableVolunteers ()
    {
        return $this->handleSharedMessage($this->leaderboardService->allTablesWithVolunteers());
    }
}
