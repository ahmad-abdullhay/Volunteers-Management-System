<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\Event\SuperVisorEventRequest;
use App\Models\Event;
use App\Models\EventUser;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
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
        $filters = $request->query();

        if (isset($filters['myEvents'])){

            $filters['user_id'] = Auth::id();
            unset($filters['myEvents']);
        }

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

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function getEventUsers(Event $event)
    {
        return $this->handleSharedMessage(
            $this->eventService->getEventUsers($event, EventUser::ACCEPTED_STATUS)
        );
    }

    public function getEventsRequests(SuperVisorEventRequest $request, Event $event)
    {
        return $this->handleSharedMessage(
            $this->eventService->getEventUsers($event, EventUser::PENDING_STATUS)
        );
    }
    public function getEventEndReport ( Event $event)
    {
     return    $this->eventService->getEventEndReport($event);
    }
}
