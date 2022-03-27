<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;
use App\Services\Shared\AuthService;

class AuthController extends BaseController
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        return $this->handleSharedMessage($this->authService->login($request->all()));
    }
}
