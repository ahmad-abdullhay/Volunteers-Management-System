<?php

namespace App\Http\Controllers\Dashboard\Badge;

use App\Common\SharedMessage;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Http\Requests\Badge\AddBadgeUserRequest;
use App\Http\Requests\EventRequest;
use App\Services\BadgeService;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
