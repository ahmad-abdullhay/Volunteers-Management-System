<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Notification;
use App\Services\NotificationService;

class EventObserver
{
    protected NotificationService $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Event "updated" event.
     *
     * @param Event $event
     * @return void
     */
    public function updated(Event $event)
    {
        if($event->isDirty('status')){
            $users = $event->acceptedUsers;
            $userIds = $users->pluck('id')->toArray();

            $this->notificationService->sendNotificationsToUsers(
                $userIds,
                Notification::NOTIFICATION_EVENT_TYPE,
                $event->id);
        }
    }

}
