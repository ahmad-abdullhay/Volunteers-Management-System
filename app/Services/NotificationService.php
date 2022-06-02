<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Repositories\Eloquent\NotificationRepository;
use App\Services\Shared\BaseService;

class NotificationService extends BaseService
{
    protected string $modelName = "Notification";
    protected $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function readNotifications($payload)
    {
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->readNotifications($payload),
            true,
            null,
            200
        );
    }

    public function deleteMyNotification($id)
    {
        return new SharedMessage(__('success.delete', ['model' => $this->modelName]),
            $this->repository->deleteMyNotification($id),
            true,
            null,
            200
        );
    }

    public function sendNotificationsToUsers($users, $model, $modelId)
    {
        return new SharedMessage(__('success.delete', ['model' => $this->modelName]),
            $this->repository->sendNotificationsToUsers($users, $model, $modelId),
            true,
            null,
            200
        );
    }
}
