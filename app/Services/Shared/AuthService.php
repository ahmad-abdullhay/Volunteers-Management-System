<?php

namespace App\Services\Shared;

use App\Common\SharedMessage;

class AuthService
{
    public function login(array $payload)
    {
        try {
            if (!auth('admin')->attempt($payload)) {
                return new SharedMessage(__('errors.wrong_email_or_password'), [], false, 401);
            }
            $admin = auth('admin')->user();
            $data['admin'] = $admin;

            $data['admin']['access_token'] =  $admin->createToken('auth_token')->plainTextToken;
            $data['admin']['roles'] = $admin->roles;
            return new SharedMessage(__('success.login', ['admin' => $admin->name]), $data, true, null, 200);
        } catch (\Exception $exception) {
            return new SharedMessage($exception->getMessage(), [], false, $exception, 500);
        }
    }
}
