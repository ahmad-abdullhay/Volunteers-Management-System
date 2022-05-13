<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseController
{
    protected EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $filters = [];
        $params = $request->query();

        if (isset($params['myEvents']))
            $filters['user_id'] = Auth::id();

        return $this->handleSharedMessage(
            $this->eventService->index(
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