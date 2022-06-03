<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\Notification\ReadNotificationsRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends BaseController
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $filters = $request->query();
        $filters['user_id'] = Auth::id();

        return $this->handleSharedMessage(
            $this->notificationService->index(
                ['*'],
                [],
                $request->per_page ?? 10,
                ['id'],
                ['desc'],
                $filters,
                null
            )
        );
    }

    public function readNotifications(ReadNotificationsRequest $request)
    {
        $notifications = $request->post();
        return $this->handleSharedMessage(
            $this->notificationService->readNotifications($notifications)
        );
    }

    public function deleteNotification($id)
    {

        return $this->handleSharedMessage(
            $this->notificationService->deleteMyNotification($id)
        );
    }
}
