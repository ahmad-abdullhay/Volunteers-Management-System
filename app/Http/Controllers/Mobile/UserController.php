<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Mobile\User\ChangeEventJoinRequest;
use App\Http\Requests\Mobile\User\JoinEventRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

    }

    public function joinEvent(JoinEventRequest $request)
    {
        return $this->handleSharedMessage(
            $this->userService->joinEvent($request->post()));
    }

    public function ChangeVolunteerJoinEventStatus(ChangeEventJoinRequest $request)
    {
        return $this->handleSharedMessage(
            $this->userService->ChangeVolunteerJoinEventStatus($request->post()));
    }
}
