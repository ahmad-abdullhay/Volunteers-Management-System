<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\LevelRequest;
use App\Http\Requests\PointRuleRequest;
use App\Models\EventUser;
use App\Models\Level;
use App\Services\LevelService;
use App\Services\PointRuleService;

class LevelController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param LevelService $service
     * @param LevelRequest $request
     */
    public function __construct(LevelService $service, LevelRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }
    public function levelsVolunteer (Level $level)
    {
        return $this->handleSharedMessage(
            $this->service->getLevelUsers($level)
        );
    }
}

